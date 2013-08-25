=== jonradio Reveal Network Activated Plugins ===
Contributors: jonradio
Donate link: http://jonradio.com/plugins
Tags: network, activation, activate, plugins, multisite
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays Network-Activated plugins on the Installed Plugins Admin panel for individual sites of a WordPress Network.

== Description ==

As the name implies, the *jonradio Reveal Network Activated Plugins* plugin displays the Plugins that WordPress would normally hide:  WordPress only displays Network Activated plugins on the **Installed Plugins** Network Admin panel.  *jonradio Reveal Network Activated Plugins* also displays Network Activated plugins on each site's **Installed Plugins** Admin panel, with *Network Activated* displayed below the plugin name where *Activate* or *Deactivate* is displayed for other plugins.

In a WordPress Network, i.e. - a single WordPress installation that provides multiple sites ("Multi-site"), Plugins can be activated on individual sites or they can be **Network Activated**, which means they are activated on all sites.  Confusion can result because WordPress does not display these Network Activated plugins on each site's **Installed Plugins** Admin panel, a confusion that this plugin hopes to eliminate.

A warning Notice is displayed if this plugin is activated on a WordPress installation that is not (yet) a WordPress Network.

Every effort has been made to not interfere with plugins that create or modify their own entry on the **Installed Plugins** Admin panel.

Security:  Network Activated plugins are only displayed to WordPress Users with the 'activate_plugins' Capability.  Please contact the Plugin Author if you wish to hide Network Activated plugins from Administrators who are not Super Admins, and this feature can be added as a Setting in a future version of this plugin. 

== Installation ==

This section describes how to install the *jonradio Reveal Network Activated Plugins* plugin and get it working.

1. Use **Add Plugin** within the WordPress Admin panel to download and install this *jonradio Reveal Network Activated Plugins* plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-reveal-network-activated-plugins/` directory to your WordPress web site's `/wp-content/plugins/` directory.
1. Activate the *jonradio Reveal Network Activated Plugins* plugin through the **Installed Plugins** Admin panel in WordPress.  If you have a WordPress Network ("Multisite"), you can either **Network Activate** this plugin through the **Installed Plugins** Network Admin panel, or Activate it individually on the sites where you wish to use it.

== Changelog ==

= 1.0 =

* Make plugin conform to WordPress plugin repository standards.
* Fix "You do not have sufficient permissions to manage plugins for this site." when trying to login