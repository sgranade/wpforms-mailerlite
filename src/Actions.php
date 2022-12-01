<?php
namespace WPFormsMailerLite;

use WPFormsMailerLite\Api\MailerLiteApi;
use WPFormsMailerLite\Controllers\PluginController;

class Actions
{
    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct() { }

    /**
     * Submit WPForms data to MailerLite to subscribe a new user.
     *
     * @access      public
     * @param array  $fields    Sanitized entry field values/properties.
     * @param array  $entry     Original $_POST global.
     * @param array  $form_data Form data and settings.
     */
    public static function subscribePersonToNewsletter( $fields, $entry, $form_data )
    {
        // Only proceed if we have a MailerLite API key and we've been passed the correct form
        $mlApiKey = PluginController::mlApiKey();
        if ( $mlApiKey === '' || absint( $form_data[ 'id' ] ) !== absint( PluginController::wpFormsFormID() ) ) {
            return;
        }

        $fieldId = PluginController::wpFormsFieldID();
        if ( !isset( $fields[ $fieldId ] ) ) {
            return;
        }
        $email = $fields[$fieldId]['value'];
        $groups = [];
        $group = PluginController::mlGroupID();
        if ( $group !== '' ) {
            $groups = [ $group ];
        }

        $API = new MailerLiteApi($mlApiKey);
        $API->addSubscriber($email, $groups);
        $responseCode = $API->responseCode();
        $errorMessage = NULL;
        $adminEmail = get_bloginfo('admin_email');
        if ( $responseCode == 200 ) {
            $errorMessage = "You're already subscribed!";
        }
        elseif ( $responseCode == 401 ) {
            $errorMessage = "Something went wrong with the API. Please contact <a href='mailto:$adminEmail'>$adminEmail>";
        }
        elseif ( $responseCode != 201 ) {
            $errorMessage = "Something went wrong (error code $responseCode). Please contact <a href='mailto:$adminEmail'>$adminEmail>";
        }
        if ( isset( $errorMessage ) ) {
            wpforms()->process->errors[ $form_data[ 'id' ] ] [ $fieldId ] = $errorMessage;
        }
    }
}
