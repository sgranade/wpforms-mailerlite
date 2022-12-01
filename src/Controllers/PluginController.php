<?php
namespace WPFormsMailerLite\Controllers;

class PluginController
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
     * Get MailerLite API key
     *
     * @access      public
     * @return      string
     */
    public static function mlApiKey()
    {
        return get_option( 'wpfml_mailerlite_api_key' );
    }

    /**
     * Get MailerLite group ID
     *
     * @access      public
     * @return      string
     */
    public static function mlGroupID()
    {
        return get_option( 'wpfml_mailerlite_group_id' );
    }

    /**
     * Get WPForms Form ID
     *
     * @access      public
     * @return      string
     */
    public static function wpFormsFormID()
    {
        return get_option( 'wpfml_wpforms_form_id' );
    }

    /**
     * Get WPForms Field ID
     *
     * @access      public
     * @return      string
     */
    public static function wpFormsFieldID()
    {
        return get_option( 'wpfml_wpforms_field_id' );
    }

}