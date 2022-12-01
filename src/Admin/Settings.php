<?php

namespace WPFormsMailerLite\Admin;

use WPFormsMailerLite\Api\MailerLiteApi;

class Settings
{
    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct() {}

    /**
     * Checks and sets ML API key
     */
    public static function setMLApiKey($key)
    {

        if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        if ( ! wp_verify_nonce( $_POST['ml_api_field_nonce'], 'wpfml_settings_form_nonce' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        if ( $key == '' ) {
            // Allow to the remove the key
            update_option( 'wpfml_mailerlite_api_key', $key );
        }
        else {
            $ML_Lists = new MailerLiteApi( $key );
            $response = $ML_Lists->validateKey();

            if ( $ML_Lists->responseCode() == 401 ) {
                add_action( 'admin_notices', [
                    '\WPFormsMailerLite\Admin\AdminNotice',
                    'error_invalid_api_key'
                ] );
            }
            elseif ($response === false) {
                $msg = $ML_Lists->getResponseBody();
                add_action( 'admin_notices', function() use ($msg) {
                    $class   = 'notice notice-error';
                    $message = '<u>Received MailerLite error</u>: ' . $msg;
                    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
                });
            }
            else {
                update_option( 'wpfml_mailerlite_api_key', $key );
                // save account information
                update_option( 'wpfml_mailerlite_account_id', $response->id );
                update_option( 'wpfml_mailerlite_account_subdomain', $response->subdomain );
            }
        }
    }

    /**
     * Checks and sets MailerLite Group ID
     */
    public static function setMLGroupId($mlGroupId)
    {
        if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        if ( ! wp_verify_nonce( $_POST['ml_group_id_field_nonce'], 'wpfml_settings_form_nonce' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        update_option( 'wpfml_mailerlite_group_id', $mlGroupId);
    }

    /**
     * Checks and sets WPForms Form ID
     */
    public static function setWPFormsFormID($wpformsFormId)
    {
        if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        if ( ! wp_verify_nonce( $_POST['wpforms_form_id_field_nonce'], 'wpfml_settings_form_nonce' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        update_option( 'wpfml_wpforms_form_id', $wpformsFormId);
    }

    /**
     * Checks and sets WPForms Field ID
     */
    public static function setWPFormsFieldID($wpformsFieldId)
    {
        if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        if ( ! wp_verify_nonce( $_POST['wpforms_field_id_field_nonce'], 'wpfml_settings_form_nonce' ) ) {
            add_action( 'admin_notices', [
                '\WPFormsMailerLite\Admin\AdminNotice',
                'notAllowedNotice'
            ] );
            return;
        }

        update_option( 'wpfml_wpforms_field_id', $wpformsFieldId);
    }

}