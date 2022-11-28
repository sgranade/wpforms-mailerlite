<?php

namespace WPFormsMailerLite\Admin;

class Menu
{

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct()
    {

    }

    /**
     * Register plugin menu
     *
     * @access      public
     */
    public static function generateLinks()
    {

        add_menu_page(
            'WPFML', 'WPFML', 'manage_options', 'wpfml_main',
            [ '\WPFormsMailerLite\Controllers\AdminController', 'settings' ], WPFORMSMAILERLITE_PLUGIN_URL . '/assets/image/icon.png'
        );
    }
}