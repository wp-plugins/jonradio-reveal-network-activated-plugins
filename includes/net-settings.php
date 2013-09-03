<?php
/*	Network Settings Page to determine if anyone but SuperAdmin can see
	Network-Activated Plugins
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
	Initiated when in the Network Admin panels.
	Used to create the Settings page for the plugin.
*/

add_action( 'network_admin_menu', 'jr_rnap_network_admin_hook' );
//	Runs just after admin_init

/**
 * Add Network Admin Menu item for plugin
 * 
 * Plugin needs its own Page in the Settings section of the Network Admin menu.
 *
 */
function jr_rnap_network_admin_hook() {
	//  Add Network Settings Page for this Plugin
	global $jr_rnap_plugin_data;
	add_submenu_page( 'settings.php', $jr_rnap_plugin_data['Name'], 'Reveal Network Activated Plugins', 'activate_plugins', 'jr_rnap_network_settings', 'jr_rnap_network_settings_page' );
	add_submenu_page( 'plugins.php', $jr_rnap_plugin_data['Name'], 'Reveal Network Activated Plugins', 'activate_plugins', 'jr_rnap_network_settings', 'jr_rnap_network_settings_page' );
}

/**
 * Network Settings page for plugin
 * 
 * Display and Process Settings page for this plugin.
 *
 */
function jr_rnap_network_settings_page() {
	global $jr_rnap_plugin_data;
	add_thickbox();
	echo '<div class="wrap">';
	screen_icon( 'plugins' );
	echo '<h2>' . $jr_rnap_plugin_data['Name'] . '</h2>';
	/*	At the time of this writing, there is no Settings API for Network Settings pages.
		Must first handle Settings saved in the previous display of this page.
	*/
	if ( isset( $_POST['action'] ) && ( 'save' === $_POST['action'] ) ) {
		check_admin_referer( 'save_network_settings', 'jonradio-reveal-network-activated-plugins' );
		if ( isset( $_POST['jr_rnap_network_settings'] ) ) {
			$post = $_POST['jr_rnap_network_settings'];
		} else {
			$post = array();
		}
		update_site_option( 'jr_rnap_network_settings', jr_rnap_validate_network_settings( $post ) );
		
		if ( isset( $_POST['menu_items'] ) ) {
			$post = jr_rnap_validate_menu_items( $_POST['menu_items'] );
		} else {
			$post = array();
		}
		if ( FALSE === $other_menu_items = get_site_option( 'menu_items' ) ) {
			$other_menu_items = array();
		} else {
			unset( $other_menu_items['plugins'] );
		}
		update_site_option( 'menu_items', array_merge( $other_menu_items, $post ) );
		
		add_settings_error(
			'jr_rnap_network_settings',
			'jr_rnap_saved',
			'Settings Saved',
			'updated'
		);
	}
	/*	Required because it is only called automatically for Admin Pages in the Settings section
	*/
	settings_errors( 'jr_rnap_network_settings' );
	
	?>
	<h3>Overview</h3>
	<p>
	WordPress does not show Network-Activated plugins on Admin panels of individual sites of a WordPress Network (Multisite).
	Activating this plugin 
	(<i>jonradio Reveal Network Activated Plugins</i>) 
	displays those Network-Activated plugins.
	</p>
	<h3>Who Sees Them?</h3>
	Activating this plugin will always reveal Network-Activated plugins to Super Administrators,
	i.e. - those authorized to manage the Network, including the viewing of this and all other Network Admin pages.
	</p>
	<p>
	The two Settings below, 
	and the "activate_plugins" Capability, 
	determine who else besides the Super Administrators can
	see Network-Activated plugins.
	</p>
	<p>
	In WordPress, Roles and Capabilities for a User can vary from site to site within a Network (Multisite).
	For example,
	the same User can have the Role of Administrator on one site, the Role of Editor on another site and not even be a Registered User on a third site.
	</p>
	<p>
	Each Role has a default set of Capabilities.
	In most situations,
	a Capability can be added or removed to a User for a specific site.
	The "activate_plugins" Capability,
	however,
	cannot be removed from a User with the Role of Administrator.
	It can, however, be disabled as described in the Settings below.
	</p>
	<form method="POST">
	<input type="hidden" name="action" value="save" />
	<?php
	wp_nonce_field( 'save_network_settings', 'jonradio-reveal-network-activated-plugins' );
	jr_rnap_echo_super_only();
	?>
	Only Super Administrators can see Network-Activated Plugins on Installed Plugins Admin panel of individual sites
	<p>
	<?php
	jr_rnap_echo_plugin_menu();
	?>
	Display Plugin menu items on individual site Admin panels, even if not Super Admin
	<br />
	<i>
	This is the same setting shown at the bottom of the Network Settings Admin panel and labelled as "Enable administration menus - Plugins".
	Whichever place you choose to control this setting,
	it also enables and disables the "activate_plugins" Capability for all Administrators who are not Super Administrators.
	</i>
	</p>
	<p><input name="save" type="submit" value="Save Changes" class="button-primary" /></p></form>
	<hr />
	<p>
	If you would like to see this Settings page on each individual Site's Admin Panels within the WordPress Network ("Multi-site")
	and/or be able to control these Settings separately for each Site,
	<a href="http://jonradio.com/contact-us/">please contact the Plugin author</a>
	and this will be added to a future version of this plugin if there is enough interest expressed by webmasters such as you.
	</p>
	<?php
	echo '<h3>System Information</h3><p>You are currently running:<ul>';
	echo "<li> &raquo; The {$jr_rnap_plugin_data['Name']} plugin Version {$jr_rnap_plugin_data['Version']}</li>";
	echo '<li> &nbsp; &raquo;&raquo; This Plugin has been <b>Network Activated</b> in a WordPress Multisite ("Network") installation';
	echo "<li> &nbsp; &raquo;&raquo; The Path to the plugin's directory is " . rtrim( jr_rnap_path(), '/' ) . '</li>';
	echo "<li> &nbsp; &raquo;&raquo; The URL to the plugin's directory is " . plugins_url() . "/{$jr_rnap_plugin_data['slug']}</li>";
	$current_wp_version = get_bloginfo( 'version' );
	echo "<li> &raquo; WordPress Version $current_wp_version</li>";
	echo '<li> &nbsp; &raquo;&raquo; WordPress language is set to ' , get_bloginfo( 'language' ) . '</li>';
	echo '<li> &raquo; ' . php_uname( 's' ) . ' operating system, Release/Version ' . php_uname( 'r' ) . ' / ' . php_uname( 'v' ) . '</li>';
	echo '<li> &raquo; ' . php_uname( 'm' ) . ' computer hardware</li>';
	echo '<li> &raquo; Host name ' . php_uname( 'n' ) . '</li>';
	echo '<li> &raquo; php Version ' . phpversion() . '</li>';
	echo '<li> &nbsp; &raquo;&raquo; php memory_limit ' . ini_get('memory_limit') . '</li>';
	echo '<li> &raquo; Zend engine Version ' . zend_version() . '</li>';
	echo '<li> &raquo; Web Server software is ' . getenv( 'SERVER_SOFTWARE' ) . '</li>';
	if ( function_exists( 'apache_get_version' ) && ( FALSE !== $apache = apache_get_version() ) ) {
		echo "<li> &nbsp; &raquo;&raquo; Apache Version $apache</li>";
	}
	global $wpdb;
	echo '<li> &raquo; MySQL Version ' . $wpdb->get_var( 'SELECT VERSION();', 0, 0 ) . '</li>';

	echo '</ul></p>';
}

function jr_rnap_echo_super_only() {
	$settings = get_site_option( 'jr_rnap_network_settings' );
	echo '<input type="checkbox" id="super_only" name="jr_rnap_network_settings[super_only]" value="super" ';
	if ( 'super' === $settings['super_only'] ) {
		echo 'checked="checked"';
	}
	echo ' />';
}

function jr_rnap_echo_plugin_menu() {
	$settings = get_site_option( 'menu_items' );
	echo '<input type="checkbox" name="menu_items[plugins]" value="1" ';
	if ( isset( $settings['plugins'] ) && ( '1' === $settings['plugins'] ) ) {
		echo 'checked="checked"';
	}
	echo ' />';
	/*	get_site_option( 'menu_items' ) assumes the following values in WordPress 3.6:
			Checkbox referred to below is labelled "Enable administration menus - Plugins"
			and is found at the bottom of /wp-admin/network/settings.php
		When first installed (checkbox shows as not checked):  FALSE
		When checked:  array( 'plugins' => '1' )
		When not checked:  array()
	
		Original code in WordPress core 3.6:
		<h3><?php _e( 'Menu Settings' ); ?></h3>
		<table id="menu" class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Enable administration menus' ); ?></th>
				<td>
			<?php
			$menu_perms = get_site_option( 'menu_items' );
			$menu_items = apply_filters( 'mu_menu_items', array( 'plugins' => __( 'Plugins' ) ) );
			foreach ( (array) $menu_items as $key => $val ) {
				echo "<label><input type='checkbox' name='menu_items[" . $key . "]' value='1'" . ( isset( $menu_perms[$key] ) ? checked( $menu_perms[$key], '1', false ) : '' ) . " /> " . esc_html( $val ) . "</label><br/>";
			}
			?>
				</td>
			</tr>
		</table>
	*/
}

function jr_rnap_validate_network_settings( $input ) {
	$valid = array();
	if ( isset ( $input['super_only'] ) ) {
		$valid['super_only'] = 'super';
	} else {
		$valid['super_only'] = '';
	}
	return $valid;
}

function jr_rnap_validate_menu_items( $input ) {
	$valid = array();
	if ( isset( $input['plugins'] ) && ( '1' === $input['plugins'] ) ) {
		$valid['plugins'] = '1';
	}
	return $valid;
}

// Add Link to the plugin's entry on the Network Admin "Plugins" Page, for easy access
add_filter( 'network_admin_plugin_action_links_' . jr_rnap_plugin_basename(), 'jr_rnap_plugin_network_action_links', 10, 1 );

/**
* Creates Settings link right on the Network Plugins Page entry.
*
* Helps the user understand where to go immediately upon Activation of the Plugin
* by creating entries on the Plugins page, right beside Deactivate and Edit.
*
* @param	array	$links	Existing links for our Plugin, supplied by WordPress
* @param	string	$file	Name of Plugin currently being processed
* @return	string	$links	Updated set of links for our Plugin
*/
function jr_rnap_plugin_network_action_links( $links ) {
	// The "page=" query string value must be equal to the slug
	// of the Settings admin page.
	array_push( $links, '<a href="' . get_bloginfo('wpurl') . '/wp-admin/network/plugins.php?page=jr_rnap_network_settings' . '">Settings</a>' );
	return $links;
}

?>