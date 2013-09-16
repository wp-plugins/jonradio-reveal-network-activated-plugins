<?php
/*	Modifications to other Network Admin panels
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
	Initiated when in the Network Admin panels.
	Used to create the plugin's changes to panels other than its Settings page.
*/


/*	Initiated at top of left sidebar only in the Delete Plugins confirmation panel in Network Admin
*/
add_action( 'update-custom_delete-selected', 'jr_rnap_delete_selected' );
function jr_rnap_delete_selected() {
	/*	Initiated at top of Network Admin panel body
	*/
	add_action( 'network_admin_notices', 'jr_rnap_delete_plugin' );
}
function jr_rnap_delete_plugin() {
	echo '<div class="wrap">';
	screen_icon();
	echo '<h2>Delete Plugins</h2>';
	require_once( jr_rnap_path() . 'includes/nwpov.php' );
	?>
	<p>
	Please check the table above to determine if any of the Plugins
	that you are attempting to Delete
	(listed below)
	are still Activated on any Site on the WordPress Network ("Multi-site").
	Deleting a Plugin that is Activated will cause it to be Activated immediately
	when it is Installed at any time in the future.
	The results of which are unpredictable.
	</p>
	</div>
	<?php
}

?>