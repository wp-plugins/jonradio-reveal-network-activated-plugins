<?php

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( current_user_can( 'activate_plugins' ) ) {
	// Add Link to the plugin's entry on the Admin "Plugins" Page, to explain pointlessness
	add_filter( 'plugin_action_links_' . jr_rnap_plugin_basename(), 'jr_rnap_plugin_action_links', 10, 1 );
}

/**
* Creates Important Notice entry right on the Plugins Page entry.
*
* Helps the user understand where to go immediately upon Activation of the Plugin
* by creating entries on the Plugins page, right beside Deactivate and Edit.
*
* @param	array	$links	Existing links for our Plugin, supplied by WordPress
* @param	string	$file	Name of Plugin currently being processed
* @return	string	$links	Updated set of links for our Plugin
*/
function jr_rnap_plugin_action_links( $links ) {
	/*	Add "Important Notice" to the end of existing Links
		The "page=" query string value must be equal to the slug
		of the Settings admin page.
	*/
	array_push( $links, '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=jr_rnap_notice' . '">Important Notice</a>' );
	return $links;
}

add_action( 'admin_menu', 'jr_rnap_admin_hook' );
//	Runs just after admin_init (below)

/**
 * Add Admin Menu item for plugin
 * 
 * Plugin needs its own Page in the Plugins section of the Admin menu.
 *
 */
function jr_rnap_admin_hook() {
	//  Add Important Notice Page for this Plugin
	global $jr_rnap_plugin_data;
	add_plugins_page( $jr_rnap_plugin_data['Name'], 'Reveal Plugins', 'activate_plugins', 'jr_rnap_notice', 'jr_rnap_notice_page' );
}

/**
 * Important Notice page for plugin
 * 
 * Display and Process Important Notice page for this plugin.
 *
 */
function jr_rnap_notice_page() {
	global $jr_rnap_plugin_data;
	add_thickbox();
	echo '<div class="wrap">';
	screen_icon( 'plugins' );
	echo '<h2>' . $jr_rnap_plugin_data['Name'] . '</h2>';
	?>		
	<h3>Important Notice</h3>
	<p>
	You have installed and activated this plugin,
	jonradio Reveal Network Activated Plugins,
	but it is currently not providing you with any useful functionality.
	Here is why:
	<ol>
	<li>This WordPress installation has <b>not</b> (yet?) been enabled for Multisite ("Network") operation; and</li>
	<li>This plugin's only purpose is to list plugins that are not otherwise listed by WordPress because:</li>
		<ol>
		<li>They are Network Activated; and</li>
		<li>They are not <i>normally</i> listed on the Installed Plugins Admin page for each site of a WordPress Multisite Network.</li>
		</ol>
	</ol>
	Of course, if you plan to activate the Multisite/Network feature of WordPress,
	you will then find this plugin quite useful.
	</p>
	<?php
	return;
}

?>