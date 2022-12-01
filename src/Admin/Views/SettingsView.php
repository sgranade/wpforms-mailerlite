<?php
namespace WPFormsMailerLite\Admin\Views;

use WPFormsMailerLite\Api\MailerLiteApi;
use WPFormsMailerLite\Controllers\PluginController;
use WPFormsMailerLite\Controllers\AdminController;

class SettingsView
{

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct($ml_api_key, $ml_group_id, $wpforms_form_id, $wpforms_field_id)
    {
        $this->view($ml_api_key, $ml_group_id, $wpforms_form_id, $wpforms_field_id);
    }

    /**
     * Output view
     *
     * @access      private
     * @return      void
     */
    private function view($ml_api_key, $ml_group_id, $wpforms_form_id, $wpforms_field_id)
    {
        $wpforms_form_id = intval($wpforms_form_id);
        $groups = [];
        if ( PluginController::mlApiKey() != '' ) {
            $API = new MailerLiteApi(PluginController::mlApiKey());
            $groups = $API->getGroups([
                'limit' => AdminController::FIRST_GROUP_LOAD
            ]);
        }
        $forms = [];
        if (function_exists( 'wpforms' )) {
            $forms = wpforms()->form->get();
        }
        // If we have a matching form, get a map of field IDs to their type
        $fields = [];
        foreach ($forms as $form) {
            if ($form->ID === $wpforms_form_id) {
                $fields = json_decode($form->post_content, true)['fields'];
                $fields = wp_list_pluck($fields, 'label', 'id');
                break;
            }
        }

        ?>
        <div class="wrap columns-2 dd-wrap">
            <h1>WPForms-MailerLite Settings</h1>

            <div class="metabox-holder has-right-sidebar">
                <?php if (!function_exists( 'wpforms' )) { ?>
                <div id="side-info-column" class="inner-sidebar">
                    <div class="postbox">
                        <h3>Install and Activate WPForms</h3>
                        <div class="inside">
                            <p>This plugin requires the <a href="https://wpforms.com/">WPForms</a> plugin be installed and active.</p>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div id="post-body">
                    <div id="post-body-content" class="mailerlite-activate">

                        <table class="form-table">
                            <?php if ( count($forms) > 0 ) : ?>
                            <tr>
                                <th valign="top">
                                    <label for="wpforms-form-id">Newsletter subscription form</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-wpforms-form-id">
                                        <select name="wpforms_form_id">
                                        <?php foreach ($forms as $form) { ?>
                                            <option value="<?php echo $form->ID ?>" <?php if ($form->ID === $wpforms_form_id) echo 'selected="true"'; ?>><?php echo $form->post_title ?></option>
                                        <?php } ?>
                                        </select>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php if ( $wpforms_form_id != "") { echo 'Update this form'; } else { echo 'Save this form'; } ?>">
                                        <input type="hidden" name="action" value="enter-wpforms-form-id">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','wpforms_form_id_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; ?>
                            
                            <?php if ( count($fields) > 0 ) : ?>
                            <tr>
                                <th valign="top">
                                    <label for="wpforms-field-id">Form field with the user's email</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-wpforms-field-id">
                                        <select name="wpforms_field_id">
                                        <?php foreach ($fields as $field_id => $field_name) { ?>
                                            <option value="<?php echo $field_id ?>" <?php if ($field_id === $wpforms_form_id) echo 'selected="true"'; ?>><?php echo $field_name ?></option>
                                        <?php } ?>
                                        </select>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php if ( $wpforms_field_id != "") { echo 'Update this field'; } else { echo 'Save this field'; } ?>">
                                        <input type="hidden" name="action" value="enter-wpforms-field-id">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','wpforms_field_id_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; ?>
                            
                            <tr>
                                <th valign="top">
                                    <label for="mailerlite-api-key">MailerLite API key</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-mailerlite-key">
                                        <input type="text" name="mailerlite_key" class="regular-text" placeholder="API-key"
                                               value="<?php if ( $ml_api_key != "") { echo "....".substr($ml_api_key, -4); } ?>" id="mailerlite-api-key"/>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $ml_api_key != "") { echo 'Update this key'; } else { echo 'Save this key'; } ?>">
                                        <input type="hidden" name="action" value="enter-mailerlite-key">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','ml_api_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            
                            <?php if ( PluginController::mlApiKey() != '' ) : ?>
                            <tr>
                                <th valign="top">
                                    <label for="mailerlite-group-id">MailerLite group to add subscribers to</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-mailerlite-group-id">
                                        <select name="mailerlite_group_id">
                                        <?php foreach ($groups as $group) { ?>
                                            <option value="<?php echo $group->id ?>" <?php if ($group->id === $ml_group_id) echo 'selected="true"'; ?>><?php echo $group->name ?></option>
                                        <?php } ?>
                                        </select>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $ml_group_id != "") { echo 'Update this group'; } else { echo 'Save this group'; } ?>">
                                        <input type="hidden" name="action" value="enter-mailerlite-group-id">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','ml_group_id_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table>

                        <br>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}