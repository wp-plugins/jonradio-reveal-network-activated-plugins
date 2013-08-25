<?php

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !is_network_admin() ) {
	/*	This code assumes that it is being included on an init action hook.
		Note that it will fail if run earlier. 
	*/
	if ( current_user_can( 'activate_plugins' ) ) {
		/*	Priority for both Actions set to 1 to allow other plugins to set links
			and add their own entries, after, effectively giving other plugins
			"the final say", so as to reduce the likelihood of conflict.
		*/
		add_action( 'pre_current_active_plugins', 'jr_rnap_netact_plugins', 1 );
		function jr_rnap_netact_plugins() {
			global $wp_list_table;
			foreach ( get_plugins() as $rel_path => $plugin_data ) {
				if ( is_plugin_active_for_network( $rel_path ) ) {
					$wp_list_table->items[$rel_path] = $plugin_data;
					add_filter( "plugin_action_links_$rel_path", 'jr_rnap_fix_links', 1, 1 );
				}
			}
			uasort( $wp_list_table->items, 'jr_rnap_sort_plugins' );
			return;
		}
		
		function jr_rnap_sort_plugins( $a, $b ) {
			return strcasecmp( $a['Name'], $b['Name'] );
		}
		
		function jr_rnap_fix_links( $links ) {
			/*	Delete existing Links and replace with "Network Activated" (not a link)
			*/
			return array( 'Network Activated' );
		}
	}
}

?>