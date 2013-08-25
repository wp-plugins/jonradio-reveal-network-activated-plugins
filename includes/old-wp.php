<?php
//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*	A Version of WordPress older than the first one supported by the Plugin
	is being run.
*/

add_action( 'all_admin_notices', 'jr_mt_all_admin_notice' );
//	Runs after admin_menu hook
add_action( 'admin_notices', 'jr_mt_all_admin_notice' );  // for older versions

function jr_mt_all_admin_notice() {
	//	Only displayed in Admin panels:
	echo '<div class="error">Deactivated the <b>jonradio Reveal Network Activated Plugins</b> plugin: requires WordPress Version 3.1 or newer; you are running Version '
		. get_bloginfo( 'version' ) . '</div>';
	global $jr_rnap_file;
	deactivate_plugins( $jr_rnap_file );
}

?>