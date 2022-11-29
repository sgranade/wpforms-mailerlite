<?php
namespace WPFormsMailerLite\Admin;

class Actions
{

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct()
    {
        if (isset($_POST['action'])) {
            if ( $_POST['action'] == 'enter-mailerlite-key'
                && isset($_POST['mailerlite_key'])) {
                Settings::setApiKey($_POST['mailerlite_key']);
            }

            if ( $_POST['action'] == 'enter-wpforms-form-id'
                && isset($_POST['wpforms_form_id'])) {
                Settings::setWPFormsFormID($_POST['wpforms_form_id']);
            }

            if ( $_POST['action'] == 'enter-mailerlite-group-id'
                && isset($_POST['mailerlite_group_id'])) {
                Settings::setMLGroupId($_POST['mailerlite_group_id']);
            }
        }
    }
}