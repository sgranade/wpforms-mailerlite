<?php
namespace WPFormsMailerLite;

use WPFormsMailerLite\Controllers\AdminController;

class Core
{
    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct()
    {
        if ( ! $this->hasServerRequirements() ) {
            return;
        }

        if ( is_admin() ) {
            new AdminController();
        }

        new Hooks();
    }

    /**
     * Run installation
     *
     * @access      private
     */
    public static function install()
    {
        if ( ! self::hasServerRequirements() ) {
            return;
        }
    }

    private static function hasServerRequirements()
    {
        global $wp_version;

        if ( self::checkPHPRequirements() ) {
            add_action(
                'admin_notices', [
                    '\WPFormsMailerLite\Admin\AdminNotice',
                    'oldPHPNotice'
                ]
            );

            self::deactivatePlugin();
        }

        if ( version_compare( $wp_version, WPFORMSMAILERLITE_WP_VERSION, '<' ) ) {
            add_action(
                'admin_notices', [
                    '\WPFormsMailerLite\Admin\AdminNotice',
                    'oldWPNotice'
                ]
            );

            self::deactivatePlugin();
        }

        return true;
    }

    private static function deactivatePlugin()
    {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        deactivate_plugins( WPFORMSMAILERLITE_PLUGIN_BASENAME );
    }

    private static function checkPHPRequirements()
    {
        return version_compare( PHP_VERSION, WPFORMSMAILERLITE_PHP_VERSION, '<' );
    }
}