<?php
/**
 * Plugin Name: WPForms-MailerLite
 * Description: Super rough plugin to tie WPForms form to MailerLite
 * Version: 0.1.0
 * Author: Stephen Granade
 * Author URI: https://stephen.granades.com/
 * License: GPLv2 or later
 * Text Domain: wpforms-mailerlite
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301,
 * USA.
 */

namespace WPFormsMailerLite;

define( 'WPFORMSMAILERLITE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPFORMSMAILERLITE_PLUGIN_URL', plugins_url( '', __FILE__ ) );

// Plugin basename
define( 'WPFORMSMAILERLITE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'WPFORMSMAILERLITE_VERSION', '0.1.0' );

define( 'WPFORMSMAILERLITE_PHP_VERSION', '7.2.5' );
define( 'WPFORMSMAILERLITE_WP_VERSION', '5.0.1' );

define( 'WPFORMSMALIERLITE_TABLE_NAME', 'wpforms_mailerlite' );

// autoload
require_once( WPFORMSMAILERLITE_PLUGIN_DIR . 'autoload.php' );

// load plugin
new Core();
