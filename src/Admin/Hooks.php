<?php

namespace WPFormsMailerLite\Admin;

class Hooks
{

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct()
    {
        $this->adminHooks();
        $this->adminScripts();
    }

    /**
     * Add admin hooks
     */
    private function adminHooks()
    {
        add_action(
            'admin_menu', [
                '\WPFormsMailerLite\Admin\Menu',
                'generateLinks',
            ]
        );
    }

    /**
     * Add admin hooks to load
     */
    private function adminScripts()
    {
        add_action(
            'admin_enqueue_scripts', [
                '\WPFormsMailerLite\Admin\Hooks',
                'load_wpfml_admin_css'
            ]
        );
    }

    /**
     * Register plugin styling
     */
    public static function load_wpfml_admin_css( $hook ) {
        $allowed_hooks = [
            'toplevel_page_wpfml_main',
            'wpfml_page_wpfml_settings',
        ];

        if ( in_array( $hook, $allowed_hooks ) ) {
            wp_register_style(
                'wpfml.css',
                WPFORMSMAILERLITE_PLUGIN_URL . '/assets/css/wpfml.css', [],
                WPFORMSMAILERLITE_VERSION
            );
            wp_enqueue_style( 'wpfml.css' );
        }
    }
}