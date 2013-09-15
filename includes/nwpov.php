<?php

/*	This file's code is adapted from Version 1.0 of the Network Plugin Overview plugin @ http://davidsword.ca/
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

jr_rnap_nwpov();

function jr_rnap_nwpov() {
	global $wpdb;

	// get all plugins..
	// this from wp-admin/includes/class-wp-plugins-list-table.php
	$plugins = apply_filters( 'all_plugins', get_plugins() );
	
	// get all sites, their name, and their plugins, put into array
	$get_sites = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}blogs` ORDER BY `blog_id`");
	$sites_plugins = array();
	$all_sites = array();
	foreach ($get_sites as $k => $site) {
		if ( '1' == $site->blog_id ) {
			/*	Main site - "first site" that was created when WordPress was installed.
				Treated differently because database tables have no prefix.
			*/
			$prefix = '';
		} else {
			$prefix = $site->blog_id . '_';
		}
		$getsite_name = $wpdb->get_row("SELECT option_value FROM {$wpdb->prefix}{$prefix}options WHERE option_name = 'blogname'");
		$getsite_plugins = $wpdb->get_row("SELECT option_value FROM {$wpdb->prefix}{$prefix}options WHERE option_name = 'active_plugins'");
		$sites_plugins[$getsite_name->option_value] = (array)unserialize($getsite_plugins->option_value);		
		$all_sites[] = $getsite_name->option_value;
	}

	// get network-wide activated plugins
	$getnetwork_plugins = $wpdb->get_row("SELECT meta_value FROM {$wpdb->prefix}sitemeta WHERE meta_key = 'active_sitewide_plugins'");
	$network_plugins = array_flip((array)unserialize($getnetwork_plugins->meta_value));		
	
	?>
	<h3>What is Activated Where?</h3>
	<style>
		#nwpov_table tr:nth-child(odd) { background: #efefef; }
		#nwpov_table td { padding: 5px; text-shadow: 1px 1px rgba(255,255,255,0.6) }
	</style>
	<table cellpadding=2 cellspacing="2" id='nwpov_table'>
		<tr>
			<td style='width: 350px;border-bottom: 1px solid #aaa;'><h4>Plugin</h4></td>
			<td style='border-bottom: 1px solid #aaa;'><h4>Activated on Site(s)</h4></td>
		</tr>
		<?php
		// cycle through plugins
		foreach ($plugins as $a_plugin_slug => $a_plugin) {
			echo "
			<tr>
				<td valign=top>{$a_plugin['Name']}</td>
				<td>";
				$count = 0;
				// if it's on entire network, highlight just that
				if (in_array($a_plugin_slug,$network_plugins)) {
					echo "<span style='color:green;'>All</span> (Network Activated)";
					$count = 99;
				} 
				// cycle through sites, see if sites have this plugin
				else {
					foreach ($sites_plugins as $this_sites_name => $this_sites_plugins) {
						if ( in_array($a_plugin_slug,$this_sites_plugins) ) {
							echo "{$this_sites_name}<br />";
							$count++;
						}
					}
				}
				// not on any site
				if ($count == 0)
					echo "<span style='color:red'>None</span> (not Activated anywhere)";
				echo "
				</td>
			</tr>";
		}
		?>                 
	</table>  
	<?php
}

?>