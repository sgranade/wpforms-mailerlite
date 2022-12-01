<?php
/**
 * Uninstall WPForms-MailerLite.
 *
 * Remove:
 * - WPForms-MailerLite settings/options
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Delete all the plugin settings.
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wpfml\_%'" );
