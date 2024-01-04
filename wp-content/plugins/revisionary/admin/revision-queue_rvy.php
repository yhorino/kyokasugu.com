<?php
/**
 * @global string       $post_type
 * @global WP_Post_Type $post_type_object
 */
global $post_type, $post_type_object, $wpdb;

if ( ! $post_types = rvy_get_manageable_types() ) {
	wp_die( esc_html__( 'You are not allowed to manage revisions.', 'revisionary' ) );
}

if (!rvy_get_option('pending_revisions') && !rvy_get_option('scheduled_revisions')) {
	wp_die( sprintf(esc_html__( 
		'%s and %s are both disabled. See Revisions > Settings.', 'revisionary' ), 
		esc_html(pp_revisions_status_label('pending-revision', 'plural')),
		esc_html(pp_revisions_status_label('future-revision', 'plural'))
	));
}

set_current_screen( 'revisionary-q' );

require_once( dirname(__FILE__).'/class-list-table_rvy.php');
$wp_list_table = new Revisionary_List_Table(['screen' => 'revisionary-q', 'post_types' => $post_types]);
$pagenum = $wp_list_table->get_pagenum();

$parent_file = 'admin.php?page=revisionary-q';
$submenu_file = 'admin.php?page=revisionary-q';

$wp_list_table->prepare_items();

$bulk_counts = array(
	'deleted'   => isset( $_REQUEST['deleted'] )   ? absint( $_REQUEST['deleted'] )   : 0,
	'updated' => 0,
	'locked' => 0,
	'submitted_count' => isset( $_REQUEST['submitted_count'] ) ? absint( $_REQUEST['submitted_count'] ) : 0,
	'declined_count' => isset( $_REQUEST['declined_count'] ) ? absint( $_REQUEST['declined_count'] ) : 0,
	'approved_count' => isset( $_REQUEST['approved_count'] ) ? absint( $_REQUEST['approved_count'] ) : 0,
	'unscheduled_count' => isset( $_REQUEST['unscheduled_count'] ) ? absint( $_REQUEST['unscheduled_count'] ) : 0,
	'published_count' => isset( $_REQUEST['published_count'] ) ? absint( $_REQUEST['published_count'] ) : 0,
	'trashed' => 0,
	'untrashed' => 0,
);

$bulk_messages = [];
$bulk_messages['post'] = array(
	'submitted_count'   => sprintf(esc_html(_n( '%s revision submitted.', '%s revisions submitted.', $bulk_counts['submitted_count'], 'revisionary' )), $bulk_counts['submitted_count']),
	'declined_count'   => sprintf(esc_html(_n( '%s revision declined.', '%s revisions declined.', $bulk_counts['declined_count'], 'revisionary' )), $bulk_counts['declined_count']),
	'approved_count'   => sprintf(esc_html(_n( '%s revision approved.', '%s revisions approved.', $bulk_counts['approved_count'], 'revisionary' )), $bulk_counts['approved_count']),
	'unscheduled_count' => sprintf(esc_html(_n( '%s revision unscheduled.', '%s revisions unscheduled.', $bulk_counts['unscheduled_count'], 'revisionary' )), $bulk_counts['unscheduled_count']),
	'published_count'   => sprintf(esc_html(_n( '%s revision published.', '%s revisions published.', $bulk_counts['published_count'], 'revisionary' )), $bulk_counts['published_count']),
	'deleted'   => sprintf(esc_html(_n( '%s revision permanently deleted.', '%s revisions permanently deleted.', $bulk_counts['deleted'] )), $bulk_counts['deleted']),
);

$bulk_messages['page'] = $bulk_messages['post'];

/**
 * Filters the bulk action updated messages.
 *
 * By default, custom post types use the messages for the 'post' post type.
 *
 * @since 3.7.0
 *
 * @param array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                             keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param array $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 */
$bulk_messages = apply_filters( 'bulk_post_updated_messages', $bulk_messages, $bulk_counts );
$bulk_counts = array_filter( $bulk_counts );

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<div class="wrap pressshack-admin-wrapper revision-q">
<header>
<h1 class="wp-heading-inline"><?php

echo '<span class="dashicons dashicons-backup"></span>&nbsp;';

if ( ! empty( $_REQUEST['post_type'] ) ) {
	$type_obj = get_post_type_object(sanitize_key($_REQUEST['post_type']));
}

if (!empty($_REQUEST['published_post'])) {
	if ($_post = get_post((int) $_REQUEST['published_post'])) {
		$published_title = $_post->post_title;
	}
}

$filters = [];

if (!empty($_REQUEST['author'])) {
	if ($_user = new WP_User((int) $_REQUEST['author'])) {
		$filters['author'] = (!empty($_REQUEST['post_status']) || !empty($_REQUEST['post_status'])) 
		? sprintf(_x('%s: ', 'Author Name', 'revisionary'), $_user->display_name)
		: $_user->display_name;
	}
}

if (!empty($_REQUEST['post_status'])) {
	if ($status_obj = get_post_status_object(sanitize_key($_REQUEST['post_status']))) {
		$filters['post_status'] = (!empty($status_obj->labels->plural)) ? $status_obj->labels->plural : $status_obj->label;
	}
}

if (!empty($_REQUEST['post_type']) && empty($published_title)) {
	$filters['post_type'] = (!empty($_REQUEST['post_status'])) 
	? sprintf(_x('of %s', 'Posts / Pages / etc.', 'revisionary'), $type_obj->labels->name) 
	: $type_obj->labels->name;
}

if (!empty($_REQUEST['post_author']) && empty($published_title)) {
	if ($_user = new WP_User((int) $_REQUEST['post_author'])) {
		$filters['post_author'] = $filters 
		? sprintf(esc_html__('%sPost Author: %s', 'revisionary'), ' - ', $_user->display_name) 
		: sprintf(esc_html__('%sPost Author: %s', 'revisionary'), '', $_user->display_name);
	}
}

$filter_csv = ($filters) ? ' (' . implode(" ", $filters) . ')' : '';

if (!empty($published_title)) {
	printf( esc_html(_x('Revision Queue for "%s"%s', 'PublishedPostName (other filter captions)', 'revisionary')), esc_html($published_title), esc_html($filter_csv) );
} else
	printf( esc_html__('Revision Queue %s', 'revisionary' ), esc_html($filter_csv));
?></h1>

<?php
if ( isset( $_REQUEST['s'] ) && strlen( sanitize_text_field($_REQUEST['s']) ) ) {
	/* translators: %s: search keywords */
	printf( ' <span class="subtitle">' . esc_html__( 'Search results for "%s"' ) . '</span>', esc_html(wp_strip_all_tags(sanitize_text_field($_REQUEST['s']))) );
}
?>

</header>
<!--<hr class="wp-header-end">-->

<?php
// If we have a bulk message to issue:
$messages = array();

foreach ( $bulk_counts as $message => $count ) {
	if ( $message == 'trashed' && isset( $_REQUEST['ids'] ) ) {
		$any_messages = true;
		break;
	} elseif (!empty($bulk_messages['post'][$message])) {
		$any_messages = true;
		break;
	}
}

if (!empty($any_messages)) {
	echo '<div id="message" class="updated notice is-dismissible"><p>';
}

foreach ( $bulk_counts as $message => $count ) {
	if ( $message == 'trashed' && isset( $_REQUEST['ids'] ) ) {
		$ids = preg_replace( '/[^0-9,]/', '', sanitize_text_field($_REQUEST['ids']));
		echo '<a href="' . esc_url( wp_nonce_url( "edit.php?post_type=$post_type&doaction=undo&action=untrash&ids=$ids", "bulk-revision-queue" ) ) . '">' . esc_html__('Undo') . '</a> ';
	
	} elseif (!empty($bulk_messages['post'][$message])) {
		echo esc_html($bulk_messages['post'][$message]) . ' ';
	}
}

if (!empty($any_messages)) {
	echo '</p></div>';
}

unset( $messages );

if (!empty($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'locked', 'skipped', 'updated', 'approved_count', 'published_count', 'deleted', 'trashed', 'untrashed' ), esc_url(esc_url_raw($_SERVER['REQUEST_URI'])) );
}
?>

<?php $wp_list_table->views(); ?>

<form name="bulk-revisions" id="bulk-revisions" method="post" action="">

<?php $wp_list_table->search_box( 'Search', 'post' ); ?>

<input type="hidden" name="page" class="post_status_page" value="revisionary-q" />
<input type="hidden" name="post_status" class="post_status_page" value="<?php echo !empty($_REQUEST['post_status']) ? esc_attr(sanitize_key($_REQUEST['post_status'])) : 'all'; ?>" />

<?php if ( ! empty( $_REQUEST['show_sticky'] ) ) { ?>
<input type="hidden" name="show_sticky" value="1" />
<?php } ?>

<?php $wp_list_table->display(); ?>

</form>

<div id="ajax-response"></div>
<br class="clear" />

<?php
do_action('revisionary_admin_footer');
?>

</div>

<?php
