=== jonradio Reveal Network Activated Plugins ===
Contributors: jonradio
Donate link: http://zatzlabs.com/plugins/
Tags: network, activation, activate, plugins, multisite
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays Network-Activated plugins on the Installed Plugins Admin panel for individual sites of a WordPress Network.

== Description ==

As the name implies, the *jonradio Reveal Network Activated Plugins* plugin displays the Plugins that WordPress would normally hide:  WordPress only displays Network Activated plugins on the **Installed Plugins** Network Admin panel.  *jonradio Reveal Network Activated Plugins* also displays Network Activated plugins on each site's **Installed Plugins** Admin panel, with *Network Activated* displayed below the plugin name where *Activate* or *Deactivate* is displayed for other plugins. In addition, the plugin's Network Admin panel, available only to Super Administrators, shows which plugins are activated on which Sites within the WordPress Network.

In a WordPress Network, i.e. - a single WordPress installation that provides multiple sites ("Multi-site"), Plugins can be activated on individual sites or they can be **Network Activated**, which means they are activated on all sites.  Confusion can result because WordPress does not display these Network Activated plugins on each site's **Installed Plugins** Admin panel, a confusion that this plugin hopes to eliminate.

A warning Notice is displayed if this plugin is activated on a WordPress installation that is not (yet) a WordPress Network.

Every effort has been made to not interfere with plugins that create or modify their own entry on the **Installed Plugins** Admin panel.

**Security**

Network Activated plugins are displayed on individual Sites in a WordPress Network:

1. When this Plugin is Network Activated, or
1. When this Plugin is Activated on the individual Site, or
1. When the User is a Super Administrator.

They are also displayed when the User is not a Super Administrator when three conditions are all met:

1. The User has the 'activate_plugins' Capability on the individual Site, and 
1. The "Enable administration menus - Plugins" checkbox is selected at the bottom of the Network Settings Admin panel (this checkbox is also provided on the plugin's Network Settings page), and
1. The "Only Super Admin" checkbox has **not** been selected on the plugin's Network Settings page.

== Installation ==

This section describes how to install the *jonradio Reveal Network Activated Plugins* plugin and get it working.

1. Use **Add Plugin** within the WordPress Admin panel to download and install this *jonradio Reveal Network Activated Plugins* plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-reveal-network-activated-plugins/` directory to your WordPress web site's `/wp-content/plugins/` directory.
1. Activate the *jonradio Reveal Network Activated Plugins* plugin through the **Installed Plugins** Admin panel in WordPress.  If you have a WordPress Network ("Multisite"), you can either **Network Activate** this plugin through the **Installed Plugins** Network Admin panel, or Activate it individually on the sites where you wish to use it.
1. Even if you plan to only activate this plugin on individual sites, you will need to temporarily Network Activate the plugin if you wish to change the "Only Super Administrators" Setting, as the plugin's Settings page only appears in the Network Settings menu when the plugin is Network Activated.

== Frequently Asked Questions ==

= Where is the Settings page for jonradio Reveal Network Activated Plugins? =

It can be found in both the Settings and Plugins submenus (left sidebar) in the Network Admin panels.  The jonradio Reveal Network Activated Plugins plugin must be Network Activated before these pages will appear in the submenus.

Even if you don't want the plugin Network Activated, you can do so temporarily, until you have the Settings set the way you want them.  The plugin stores the settings until you Uninstall the plugin, which means they will still be available after you Network Deactivate the plugin and later Activate it on one or more individual Sites in a WordPress Network.

= Where is the Plugins menu item in the left sidebar of the Admin panel? =

By default, WordPress only displays a Plugins menu item to Super Administrators.

To change this behaviour, select the "Enable administration menus - Plugins" checkbox at the bottom of the Network Settings Admin panel.  For your convenience, this checkbox is also provided in the plugin's Network Settings page.

== Changelog ==

= 1.2 =
* Expand plugin's Network Admin panel to show where (which sites) each plugin is Activated.

= 1.1 =
* Add Network Admin panel with network-wide option to only allow Super Admins to view Network-Activated Plugins, or not.

= 1.0 =
* Make plugin conform to WordPress plugin repository standards.
* Fix "You do not have sufficient permissions to manage plugins for this site." when trying to login

== Upgrade Notice ==

= 1.2 =
Indicate Sites where each plugin is Activated.

= 1.1 =
Control whether Site Admins can see Network-Activated Plugins