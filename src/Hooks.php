<?php
namespace WPFormsMailerLite;

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
        $this->initHooks();
    }

    private function initHooks()
    {
        register_activation_hook(
            WPFORMSMAILERLITE_PLUGIN_BASENAME, [
                '\WPFormsMailerLite\Core',
                'install'
            ]
        );

        add_action(
            'wpforms_process', [
                '\WPFormsMailerLite\Actions',
                'subscribePersonToNewsletter'
            ],
            10,
            3 );

        if ( is_admin() ) {
            add_action(
                'init', [
                    '\WPFormsMailerLite\Controllers\AdminController',
                    'init'
                ]
            );
        }
    }
}