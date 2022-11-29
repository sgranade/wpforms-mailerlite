<?php
namespace WPFormsMailerLite\Controllers;

use WPFormsMailerLite\Admin\Actions;
use WPFormsMailerLite\Admin\Hooks;
use WPFormsMailerLite\Admin\Views\SettingsView;

class AdminController
{
    const FIRST_GROUP_LOAD = 100;

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     * @since       1.5.0
     */
    public function __construct() {}

    /**
     * Show Settings view
     *
     * @access      public
     * @return      void
     * @since       1.5.0
     */
    public static function settings()
    {
        new SettingsView(self::apiKey(), self::wpFormsID(), self::mlGroupID());
    }

    /**
     * Register Actions and Hooks
     *
     * @access      public
     * @return      void
     * @since       1.5.0
     */
    public static function init()
    {
        if ( is_admin() ) {
            new Actions();
            new Hooks();
        }
    }

    /**
     * Get MailerLite API key
     *
     * @access      public
     * @return      string
     */
    public static function apiKey()
    {
        return get_option( 'mailerlite_api_key' );
    }

    /**
     * Get WPForms ID
     *
     * @access      public
     * @return      string
     */
    public static function wpFormsID()
    {
        return get_option( 'wpfml_wpforms_id' );
    }

    /**
     * Get MailerLite group ID
     *
     * @access      public
     * @return      string
     */
    public static function mlGroupID()
    {
        return get_option( 'wpfml_group_id' );
    }
}