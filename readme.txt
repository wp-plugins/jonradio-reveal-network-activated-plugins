=== jonradio Reveal Network Activated Plugins ===
Contributors: jonradio
Donate link: http://jonradio.com/plugins
Tags: network, activation, activate, plugins, multisite
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays Network-Activated and Must-Use (MU) plugins, and Drop-ins on the Installed Plugins Admin panel for individual sites of a WordPress Network.

== Description ==

Beyond what the name implies, the *jonradio Reveal Network Activated Plugins* plugin can display all Plugins that WordPress would normally hide:  WordPress only displays Network Activated and Must-Use plugins, as well as Drop-ins, on the **Installed Plugins** Network Admin panel; even there, they can be easily missed.  Under the control of any Super Administrator, *jonradio Reveal Network Activated Plugins* allows Network Activated and Must-Use plugins, and Drop-ins, to be displayed on each site's **Installed Plugins** Admin panel, with *Network Activated*, *Must-Use Plugin* or "Drop-in" displayed below the plugin name where *Activate* or *Deactivate* is displayed for other plugins. In addition, the plugin's Network Admin panel, available only to Super Administrators, shows which Plugins are activated on which Sites within the WordPress Network.

In a WordPress Network, i.e. - a single WordPress installation that provides multiple sites ("Multi-site"), Plugins can be activated on individual sites or they can be **Network Activated**, which means they are activated on all sites.  In addition, Must-Use plugins are automatially activated if present and Drop-ins are activated Network-wide by a Constant set in wp-config.php. Confusion can result because WordPress does not display any of these plugins on each site's **Installed Plugins** Admin panel, a confusion that this plugin hopes to eliminate.

A warning Notice is displayed if this plugin is activated on a WordPress installation that is not (yet) a WordPress Network.

Every effort has been made to not interfere with plugins that create or modify their own entry on the **Installed Plugins** Admin panel.

= Settings =

A Settings page for this plugin is available to Super Administrators on both the Plugins and Settings submenus within the Network Administration panels.  It determines which plugins are visible on the Plugins Admin panel of each site within the Network.

A "Who Sees Them?" table of choices can be used to set who sees Network-Activated and Must-Use plugins, and Drop-ins.  It can even be used to hide any or all of them from everyone.

The Plugins row of the table actually controls the same Setting as the "Enable administration menus - Plugins" checkbox at the bottom of the Network Settings Admin panel.  It is provided here to avoid the confusion that otherwise exists when Super Administrators cannot figure out why their Site Administrators do not even have a Plugin menu on their Site Admin panels.

Within the "Who Sees Them?" table, the column entitled "Site Administrators" also refers to anyone else with the "activate_plugins" Capability for the Site.

= Definitions =

Super Administrator - controls the Network (multi-site) settings and setup, as well as settings and setup for all individual Sites within the Network, through access to all Admin panels for the Network and all Sites.

Site Administrator - has no access to Network settings and setup, but does have access to Admin panels for any Site for which he has the Role of Administrator.

"activate_plugins" Capability - one of many settings for a User for a specific Site, i.e. - each User either has or does not have the "activate_plugins" Capability for a given Site.  Anyone with the Role of Administrator for a Site automatically has the "activate_plugins" Capability and it cannot be removed.  However, it can be disabled through the "Enable administration menus - Plugins" Network setting described above.

== Installation ==

This section describes how to install the *jonradio Reveal Network Activated Plugins* plugin and get it working.  Although not described below, it can be installed on a non-Multisite, i.e. - not a WordPress Network, but the plugin provides no value except to WordPress Networks.

1. Use **Add Plugin** within the WordPress Admin panel to download and install this *jonradio Reveal Network Activated Plugins* plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-reveal-network-activated-plugins/` directory to your WordPress web site's `/wp-content/plugins/` directory.
1. **Network Activate** this plugin through the **Installed Plugins** Network Admin panel (preferred method).  Alternatively, you can Activate it individually on the sites where you wish to use it, but you will not have access to the plugin's Setting page which is located in the Network Admin panels.  Because these Settings almost certainly will require your review, the only practical alternative is to Network Activate the plugin, adjust its Settings, Network Deactivate the plugin, and Activate it individually on the sites where you wish to use it.

== Frequently Asked Questions ==

= Where is the Settings page for jonradio Reveal Network Activated Plugins? =

It can be found in both the Settings and Plugins submenus (left sidebar) in the Network Admin panels.  The jonradio Reveal Network Activated Plugins plugin must be Network Activated before these pages will appear in the submenus.

Even if you don't want the plugin Network Activated, you can do so temporarily, until you have the Settings set the way you want them.  The plugin stores the settings until you Uninstall the plugin, which means they will still be available after you Network Deactivate the plugin and later Activate it on one or more individual Sites in a WordPress Network.

= Where is the Plugins menu item in the left sidebar of the Admin panel? =

By default, WordPress only displays a Plugins menu item to Super Administrators.

To change this behaviour, select the "Enable administration menus - Plugins" checkbox at the bottom of the Network Settings Admin panel.  For your convenience, this same WordPress setting can be controlled from the plugin's Network Settings page, through the Plugins row of the "Who Sees Them?" permissions table.

== Changelog ==

= 2.0 =
* Add Must-Use plugins and Drop-ins to the Installed Plugins Admin panel for individual sites of a WordPress Network.
* Add Settings to control the display of different types of plugins on the Installed Plugins Admin panel for individual sites of a WordPress Network.

= 1.2 =
* Expand plugin's Network Admin panel to show where (which sites) each plugin is Activated.

= 1.1 =
* Add Network Admin panel with network-wide option to only allow Super Admins to view Network-Activated Plugins, or not.

= 1.0 =
* Make plugin conform to WordPress plugin repository standards.
* Fix "You do not have sufficient permissions to manage plugins for this site." when trying to login

== Upgrade Notice ==

= 2.0 =
Display Must-Use plugins and Drop-ins.

= 1.2 =
Indicate Sites where each plugin is Activated.

= 1.1 =
Control whether Site Admins can see Network-Activated Plugins