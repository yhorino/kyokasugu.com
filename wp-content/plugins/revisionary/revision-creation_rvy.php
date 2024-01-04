<?php
namespace PublishPress\Revisions;

class RevisionCreation {
	var $revisionary;
	var $options = [];

	function __construct($args = []) {
		// Support instantiation downstream from Revisionary constructor (before its return value sets global variable)
		if (!empty($args) && is_array($args) && !empty($args['revisionary'])) {
			$this->revisionary = $args['revisionary'];
		}
	}

	// @todo: status change handler for draft => future-revision
	function flt_future_revision_status_change($revision_status, $old_status, $revision_id) {
		if ('future-revision' == $revision_status) {
			require_once( dirname(__FILE__).'/admin/revision-action_rvy.php');
			rvy_update_next_publish_date(['revision_id' => $revision_id]);
		}

		if ('pending-revision' == $revision_status) {
			$revision = get_post($revision_id);
			
			do_action('revisionary_submit_revision', $revision);

			/**
			* Trigger after a revision creation.
			*
			* @param int $revision The revision object.
			*/
			do_action('revisionary_created_revision', $revision);
		}
	}

	function flt_pending_revision_data( $data, $postarr ) {

		if (rvy_is_revision_status($postarr['post_mime_type'])) {
			if ($data['post_name'] != $postarr['post_name']) {
				add_post_meta($revision_id, '_requested_slug', $data['post_name']);
				$data['post_name'] = $postarr['post_name'];
			}
		}

		return $data;	
	}

	static function fltInterruptPostMetaOperation($interrupt) {
		return true;
	}
	
	// Create a new revision, usually 'draft-revision' (Working Copy) or 'future-revision' (Scheduled Revision)

	// If an autosave was stored for the current user prior to this creation, it will be retrieved in place of the main revision. 
	function createRevision($post_id, $revision_status, $args = []) {
        global $wpdb, $current_user;

		$is_revision = rvy_in_revision_workflow($post_id);

		$main_post_id = $is_revision ? rvy_post_id($post_id) : $post_id;

        $published_post = get_post($main_post_id);
		$source_post = get_post($post_id);

		$set_post_properties = [       
			'post_content',          
			'post_content_filtered', 
			'post_title',            
			'post_excerpt',                   
			'comment_status',        
			'ping_status',           
			'post_password',                            
			'menu_order',                 
		];

		$data = [];

		if (!$is_revision) {
			if ($autosave_post = Utils::get_post_autosave($post_id, $current_user->ID)) {
				if (strtotime($autosave_post->post_modified_gmt) > strtotime($source_post->post_modified_gmt)) {
					$use_autosave = true;
					$args['meta_post_id'] = $autosave_post->ID;
				}
			}
		}

		foreach($set_post_properties as $prop) {
			$data[$prop] = (!empty($use_autosave) && !empty($autosave_post->$prop)) ? $autosave_post->$prop : $source_post->$prop;
		}

		$data['post_type'] = $source_post->post_type;
		$data['post_parent'] = ($is_revision) ? $published_post->post_parent : $source_post->post_parent;

		if (!defined('REVISIONARY_LEGACY_REVISION_AUTHOR') && !empty($current_user) && !empty($current_user->ID)) {
			$data['post_author'] = $current_user->ID;
		}

		if (!empty($args['time_gmt'])) {
			$timestamp = $args['time_gmt'];
			$data['post_date_gmt'] = gmdate( 'Y-m-d H:i:s', $timestamp);
			$data['post_date'] = gmdate( 'Y-m-d H:i:s', $timestamp + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ));
		}

		$args['main_post_id'] = $main_post_id;

		$revision_id = $this->insert_revision($data, $source_post->ID, $revision_status, $args);

		if (!empty($use_autosave)) {
			$wpdb->delete($wpdb->posts, ['ID' => $autosave_post->ID]);
		}

		if ('future-revision' == $revision_status) {
			require_once( dirname(__FILE__).'/admin/revision-action_rvy.php');
			rvy_update_next_publish_date(['revision_id' => $revision_id]);
		}

		if (!$revision_id || !is_scalar($revision_id)) { // update_post_data() returns array or object on update abandon / failure
			return;
		}

		$post = get_post($revision_id);

		$url = apply_filters('revisionary_create_revision_redirect', rvy_admin_url("post.php?post=$revision_id&action=edit"), $revision_id);

		if (!empty($args['suppress_redirect'])) {
			return $revision_id;
		}

		wp_redirect($url);
		exit;
	}

    private function insert_revision($data, $base_post_id, $revision_status, $args = []) {
		global $wpdb, $current_user;

		$data['post_mime_type'] = $revision_status;

		switch($revision_status) {
			case 'draft-revision':
				$data['post_status'] = 'draft';

				$data['post_date'] = current_time( 'mysql' );
				$data['post_date_gmt'] = current_time( 'mysql', 1 );
				break;

			case 'future-revision':
				$data['post_status'] = 'pending';
				break;

			default:
				$data['post_status'] = 'pending';
		}

		$main_post_id = (!empty($args['main_post_id'])) ? $args['main_post_id'] : $base_post_id;

		$data['comment_count'] = $main_post_id; 	// buffer this value in posts table for query efficiency (actual comment count stored for published post will not be overwritten)

		$data['post_author'] = $current_user->ID;		// store current user as revision author (but will retain current post_author on restoration)

		$data['post_modified'] = current_time( 'mysql' );
		$data['post_modified_gmt'] = current_time( 'mysql', 1 );

		if ( $future_date = ! empty($data['post_date']) && ( strtotime($data['post_date_gmt'] ) > agp_time_gmt() ) ) {  // in past versions, $future_date was also passed to get_revision_msg()
			// round down to zero seconds
			$data['post_date_gmt'] = date( 'Y-m-d H:i:00', strtotime( $data['post_date_gmt'] ) );
			$data['post_date'] = date( 'Y-m-d H:i:00', strtotime( $data['post_date'] ) );
		}

		// @todo: confirm this is still needed
		$data['guid'] = '';
		$data['post_name'] = '';

		$revision_id = wp_insert_post(\wp_slash($data), true);

		if (is_wp_error($revision_id)) {
			return new \WP_Error(esc_html__( 'Could not insert revision into the database', 'revisionary'));
		}

		$update_data = ('pending-revision' == $data['post_mime_type'])  // 
		? ['comment_count' => $main_post_id, 'post_modified_gmt' => $data['post_modified_gmt'], 'post_modified' => $data['post_modified']]
		: ['comment_count' => $main_post_id];

		$wpdb->update($wpdb->posts, $update_data, ['ID' => $revision_id]);

		// Use the newly generated $post_ID.
		$where = array( 'ID' => $revision_id );

		// make sure autosave still exists
		if (!empty($args['meta_post_id'])) {
			$post = get_post($args['meta_post_id']);

			if (empty($post) || empty($post->post_type)) {
				unset($args['meta_post_id']);
			}
		}

		if (!empty($args['meta_post_id'])) {
			revisionary_copy_terms($args['meta_post_id'], $revision_id);
			revisionary_copy_postmeta($args['meta_post_id'], $revision_id);

			// For taxonomies and meta keys not stored for the autosave, use published copies
			revisionary_copy_terms($base_post_id, $revision_id, ['empty_target_only' => true]);
			revisionary_copy_postmeta($base_post_id, $revision_id, ['empty_target_only' => true]);
		} else {
			// If term selections are not posted for revision, store current published terms
			revisionary_copy_terms($base_post_id, $revision_id);
			revisionary_copy_postmeta($base_post_id, $revision_id);
		}

		rvy_update_post_meta($revision_id, '_rvy_base_post_id', $base_post_id);
		rvy_update_post_meta($base_post_id, '_rvy_has_revisions', true);
	
		// Set GUID.  @todo: still needed?
		if ( '' == get_post_field( 'guid', $revision_id ) ) {
			// need to give revision a guid for 3rd party editor compat (post_ID is ID of revision)
			$wpdb->update( $wpdb->posts, array( 'guid' => get_permalink( $revision_id ) ), $where );
		}
	
		$data['ID'] = $revision_id;
		do_action('revisionary_new_revision', $revision_id, $revision_status);

		return (int) $revision_id; // only return array in calling function should return
	}
}
