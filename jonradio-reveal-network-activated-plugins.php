<?php
/*
Plugin Name: jonradio Reveal Network Activated Plugins
Plugin URI: http://zatzlabs.com/plugins/
Description: Displays Network-Activated plugins on Installed Plugins Admin page for individual sites of a WordPress Network.
Version: 1.0
Author: David Gewirtz
Author URI: http://zatzlabs.com/plugins/
License: GPLv2
*/

/*  Copyright 2013  jonradio  (email : info@zatz.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {
	add_action( 'init', 'jr_rnap_init' );
	function jr_rnap_init() {
		if ( is_user_logged_in() ) {
			global $jr_rnap_file;
			$jr_rnap_file = __FILE__;
			
			/*	Catch old unsupported version of WordPress before any damage can be done.
			*/
			if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'includes/old-wp.php' );
			} else {
				global $jr_rnap_path;
				$jr_rnap_path = plugin_dir_path( __FILE__ );
				/**
				* Return Plugin's full directory path with trailing slash
				* 
				* Local XAMPP install might return:
				*	C:\xampp\htdocs\wpbeta\wp-content\plugins\jonradio-reveal-network-activated-plugins/
				*
				*/
				function jr_rnap_path() {
					global $jr_rnap_path;
					return $jr_rnap_path;
				}
				
				global $jr_rnap_plugin_basename;
				$jr_rnap_plugin_basename = plugin_basename( __FILE__ );
				/**
				* Return Plugin's Basename
				* 
				* For this plugin, it would be:
				*	jonradio-multiple-themes/jonradio-multiple-themes.php
				*
				*/
				function jr_rnap_plugin_basename() {
					global $jr_rnap_plugin_basename;
					return $jr_rnap_plugin_basename;
				}
				
				global $jr_rnap_plugin_data;
				if ( !function_exists( 'get_plugin_data' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}
				$jr_rnap_plugin_data = get_plugin_data( __FILE__ );
				
			
				if ( is_multisite() ) {
					require_once( jr_rnap_path() . 'includes/multi-site.php' );
				} else {
					require_once( jr_rnap_path() . 'includes/single-site.php' );
				}
			}
		}
	}
}

?>