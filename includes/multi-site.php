<?php

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( is_network_admin() ) {
	require_once( jr_rnap_path() . 'includes/net-settings.php' );
	require_once( jr_rnap_path() . 'includes/net-page-mods.php' );
} else {
	/*	This code assumes that it is being included on an init action hook.
		Note that it will fail if run earlier. 
	*/
	
	/*	Be sure that Plugin menu is even visible
	*/
	$menu_items = get_site_option( 'menu_items' );
	/*	User can be either a SuperAdmin or the Settings allow a regular Admin,
		but no matter what, the user must have 'activate_plugins' Capability.
	*/
	if ( is_super_admin() || ( isset( $menu_items['plugins'] ) && ( '1' === $menu_items['plugins'] ) && current_user_can( 'activate_plugins' ) ) ) {
		/*	Priority for both Actions set to 1 to allow other plugins to set links
			and add their own entries, after, effectively giving other plugins
			"the final say", so as to reduce the likelihood of conflict.
		*/
		add_action( 'pre_current_active_plugins', 'jr_rnap_show_more_plugins', 1 );
		/**
		* Add Plugins to Installed Plugins page.
		*
		* For individual sites within a WordPress Network,
		* expand the Installed Plugins Admin panel to include
		* Network-Activated plugins, Must-Use plugins and Drop-ins.
		*
		* @return void
		*/		
		function jr_rnap_show_more_plugins() {
			global $wp_list_table, $plugins, $totals;
			
			$wp_list_table = _get_list_table('WP_Plugins_List_Table');
			/*	Re-do relevant parts of prepare_items()
			*/
			$plugins = array(
				'all'                => array(),
				'search'             => $plugins['search'],
				'active'             => array(),
				'inactive'           => array(),
				'recently_activated' => array(),
				'upgrade'            => array()
			);
			
			/*	Use Settings as Permissions to determine what gets displayed
			*/
			$settings = get_site_option( 'jr_rnap_network_settings' );
			if ( ( 'siteadmin' === $settings['netact'] ) || ( is_super_admin() && ( 'super' === $settings['netact'] ) ) ) {
				$plugins['all'] = (array) apply_filters( 'all_plugins', get_plugins() );
			} else {
				foreach ( (array) apply_filters( 'all_plugins', get_plugins() ) as $plugin_file => $plugin_data ) {
					if ( !is_plugin_active_for_network( $plugin_file ) ) {		
						$plugins['all'][ $plugin_file ] = $plugin_data;
					}
				}
			}
			if ( ( 'siteadmin' === $settings['mustuse'] ) || ( is_super_admin() && ( 'super' === $settings['mustuse'] ) ) ) {
				$plugins['mu'] = get_mu_plugins();
			} else {
				$plugins['mu'] = array();
			}
			if ( ( 'siteadmin' === $settings['dropins'] ) || ( is_super_admin() && ( 'super' === $settings['dropins'] ) ) ) {
				$plugins['di'] = get_dropins();
			} else {
				$plugins['di'] = array();
			}
			
			$plugins['all'] = array_merge( $plugins['all'], $plugins['mu'], $plugins['di'] );
			/*	Plugins in Need of an Update
			*/
			if ( current_user_can( 'update_plugins' ) ) {
				$current = get_site_transient( 'update_plugins' );
				foreach ( (array) $plugins['all'] as $plugin_file => $plugin_data ) {
					if ( isset( $current->response[ $plugin_file ] ) ) {
						$plugins['all'][ $plugin_file ]['update'] = true;
						$plugins['upgrade'][ $plugin_file ] = $plugins['all'][ $plugin_file ];
					}
				}
			}
			/*	Recently Activated
			*/
			set_transient( 'plugin_slugs', array_keys( $plugins['all'] ), DAY_IN_SECONDS );
			$recently_activated = get_option( 'recently_activated', array() );
			foreach ( $recently_activated as $key => $time ) {
				if ( $time + WEEK_IN_SECONDS < time() ) {
					unset( $recently_activated[$key] );
				}
			}
			update_option( 'recently_activated', $recently_activated );
			/*	Decide what is Activated and what is not,
				and format Drop-Ins data, at the same time.
			*/
			$dropin_data = _get_dropins();
			foreach ( (array) $plugins['all'] as $plugin_file => $plugin_data ) {
				if ( isset( $plugins['di'][ $plugin_file ] ) ) {
					$data = $plugin_data;
					$data['Description'] = $dropin_data[ $plugin_file ][0];
					if ( ( TRUE === $dropin_data[ $plugin_file ][1] ) || ( ( defined( $dropin_data[ $plugin_file ][1] ) ) && ( TRUE === constant( $dropin_data[ $plugin_file ][1] ) ) ) ) {
						$plugins['active'][ $plugin_file ] = $data;
					} else {
						$data['Description'] .= ' <strong>Inactive:</strong> Requires <code>define( ' . "'" 
							. $dropin_data[ $plugin_file ][1] 
							. "', true );</code> in <code>wp-config.php</code>."; 
						$plugins['inactive'][ $plugin_file ] = $data;
					}
					$plugins['di'][ $plugin_file ] = $data;
					$plugins['all'][ $plugin_file ] = $data;
				} else {
					if ( isset( $plugins['mu'][ $plugin_file ] )
						|| is_plugin_active( $plugin_file ) 
						|| is_plugin_active_for_network( $plugin_file )
						)
					{
						$plugins['active'][ $plugin_file ] = $plugin_data;
					} else {
						$plugins['inactive'][ $plugin_file ] = $plugin_data;
						if ( isset( $recently_activated[ $plugin_file ] ) ) {
							$plugins['recently_activated'][ $plugin_file ] = $plugin_data;
						}
					}
				}
			}
			/*	Update Counts
				Will need to add rest of prepare_items(), too
			*/
			$totals = array();
			foreach ( $plugins as $type => $list ) {
				if ( 'mu' == $type ) {
					$type = 'mustuse';
				} else {
					if ( 'di' == $type ) {
						$type = 'dropins';
					}
				}
				$totals[ $type ] = count( $list );
			}

			/*	Update $status (not used until now)
			*/
			global $status;
			if ( 'search' != $status ) {
				if ( isset( $_REQUEST['plugin_status'] ) && in_array( $_REQUEST['plugin_status'], array( 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins' ) ) ) {
					$status = $_REQUEST['plugin_status'];
				} else {
					$status = 'all';
				}
				if ( 'mustuse' == $status ) {
					$status = 'mu';
				} else {
					if ( 'dropins' == $status ) {
						$status = 'di';
					}
				}
				if ( empty( $plugins[ $status ] ) ) {
					$status = 'all';
				}
			}
			/*	Remove Checkbox column for Drop-ins and Must Use pages
			*/
			if ( in_array( $status, array( 'mu', 'di' ) ) ) {
				$get_columns = $wp_list_table->get_columns();
				unset( $get_columns['cb'] );
				$wp_list_table->_column_headers = array( 
					$get_columns,		// columns
					array(),			// hidden
					$wp_list_table->get_sortable_columns(),	// sortable
				);
			}
			/*	Re-create List for Display on Page
			*/
			$wp_list_table->items = array();
			foreach ( $plugins[ $status ] as $plugin_file => $plugin_data ) {
				// Translate, Don't Apply Markup, Sanitize HTML
				$wp_list_table->items[$plugin_file] = _get_plugin_data_markup_translate( $plugin_file, $plugin_data, false, true );
			}
			/*	Sort Revised Plugin List for display
			*/
			function jr_rnap_sort_plugins( $a, $b ) {
				return strcasecmp( $a['Name'], $b['Name'] );
			}			
			uasort( $wp_list_table->items, 'jr_rnap_sort_plugins' );
			/*	Label Network-Activated Plugins
			*/
			foreach ( $plugins['active'] as $plugin_file => $plugin_data ) {
				if ( is_plugin_active_for_network( $plugin_file ) ) {		
					add_filter( "plugin_action_links_$plugin_file", 'jr_rnap_fix_links', 1, 1 );
				}
			}
			/*	Label Must-Use Plugins
			*/
			foreach ( $plugins['mu'] as $plugin_file => $plugin_data ) {
				add_filter( "plugin_action_links_$plugin_file", 'jr_rnap_fix_mu_links', 1, 1 );
				add_action( "after_plugin_row_$plugin_file", 'jr_rnap_after_mu_di_plugin_row' );
			}
			/*	Label Drop-ins
			*/
			foreach ( $plugins['di'] as $plugin_file => $plugin_data ) {
				add_filter( "plugin_action_links_$plugin_file", 'jr_rnap_fix_dropin_links', 1, 1 );
				add_action( "after_plugin_row_$plugin_file", 'jr_rnap_after_mu_di_plugin_row' );
			}
			function jr_rnap_fix_links( $links ) {
				/*	Delete existing Links and replace with "Network Activated" (not a link)
				*/
				return array( 'Network Activated' );
			}
			function jr_rnap_fix_mu_links( $links ) {
				global $status, $jr_rnap_save_status;
				$jr_rnap_save_status = $status;
				$status = 'mustuse';
				/*	Delete existing Links and replace with "Must-Use Plugin" (not a link)
				*/
				return array( 'Must-Use Plugin' );
			}
			function jr_rnap_fix_dropin_links( $links ) {
				global $status, $jr_rnap_save_status;
				$jr_rnap_save_status = $status;
				$status = 'dropins';
				/*	Delete existing Links and replace with "Drop-in" (not a link)
				*/			
				return array( 'Drop-in' );
			}
			function jr_rnap_after_mu_di_plugin_row() {
				global $status, $jr_rnap_save_status;
				/*	Restore $status
				*/
				$status = $jr_rnap_save_status;
				return;
			}
			/*	Define which Plugins are Activated in active_plugins option field
			*/
			add_filter( 'pre_option_active_plugins', 'jr_rnap_active_plugins' );
			function jr_rnap_active_plugins() {
				global $plugins;
				$active = array();
				foreach ( $plugins['active'] as $plugin_file => $plugin_data ) {
					$active[] = $plugin_file;
				}
				return $active;
			}
			/*	Re-do Pagination, etc.
			*/
			global $orderby, $order, $page;
			if ( 'di' === $status ) {
				$status_unmod = 'dropins';
			} else {
				if ( 'mu' === $status ) {
					$status_unmod = 'mustuse';
				} else {
					$status_unmod = $status;
				}
			}
			$total_this_page = $totals[ $status_unmod ];

			if ( $orderby ) {
				$orderby = ucfirst( $orderby );
				$order = strtoupper( $order );
	
				uasort( $wp_list_table->items, array( &$wp_list_table, '_order_callback' ) );
			}
	
			$plugins_per_page = $wp_list_table->get_items_per_page( str_replace( '-', '_', $wp_list_table->screen->id . '_per_page' ), 999 );
	
			$start = ( $page - 1 ) * $plugins_per_page;
	
			if ( $total_this_page > $plugins_per_page )
				$wp_list_table->items = array_slice( $wp_list_table->items, $start, $plugins_per_page );
	
			$wp_list_table->set_pagination_args( array(
				'total_items' => $total_this_page,
				'per_page' => $plugins_per_page,
			) );
			
			return;
		}
	}
}
			
?>