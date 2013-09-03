<?php
//	Ensure call comes from WordPress, not a hacker or anyone else trying direct access.
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

/*	Delete Settings.
*/
delete_site_option( 'jr_rnap_network_settings' );
delete_site_option( 'jr_rnap_internal_settings' );

?>