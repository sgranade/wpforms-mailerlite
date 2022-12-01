<?php
namespace WPFormsMailerLite\Controllers;

use WPFormsMailerLite\Admin\Actions;
use WPFormsMailerLite\Admin\Hooks;
use WPFormsMailerLite\Admin\Views\SettingsView;
use WPFormsMailerLite\Controllers\PluginController;

class AdminController
{
    const FIRST_GROUP_LOAD = 100;

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct() {}

    /**
     * Show Settings view
     *
     * @access      public
     * @return      void
     */
    public static function settings()
    {
        new SettingsView(
            PluginController::mlApiKey(), 
            PluginController::mlGroupID(), 
            PluginController::wpFormsFormID(), 
            PluginController::wpFormsFieldID()
        );
    }

    /**
     * Register Actions and Hooks
     *
     * @access      public
     * @return      void
     */
    public static function init()
    {
        if ( is_admin() ) {
            new Actions();
            new Hooks();
        }
    }
}