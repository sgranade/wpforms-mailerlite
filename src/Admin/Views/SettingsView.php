<?php
namespace WPFormsMailerLite\Admin\Views;

use WPFormsMailerLite\Api\MailerLiteApi;
use WPFormsMailerLite\Controllers\AdminController;

class SettingsView
{

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct($api_key, $wpforms_id, $ml_group_id)
    {
        $this->view($api_key, $wpforms_id, $ml_group_id);
    }

    /**
     * Output view
     *
     * @access      private
     * @return      void
     */
    private function view($api_key, $wpforms_id, $ml_group_id)
    {
        $groups = [];
        if ( AdminController::apiKey() != '' ) {
            $API = new MailerLiteApi(AdminController::apiKey());
            $groups = $API->getGroups([
                'limit' => AdminController::FIRST_GROUP_LOAD
            ]);
        }
        $forms = [];
        if (function_exists( 'wpforms' )) {
            $forms = wpforms()->form->get();
        }

        ?>
        <div class="wrap columns-2 dd-wrap">
            <h1><?php echo __( 'Plugin settings', 'mailerlite' ); ?></h1>

            <div class="metabox-holder has-right-sidebar">
                <div id="post-body">
                    <div id="post-body-content" class="mailerlite-activate">

                        <table class="form-table">
                            <?php if ( count($forms) > 0 ) : ?>
                            <tr>
                                <th valign="top">
                                    <label for="mailerlite-group-id">Newsletter subscription form</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-wpforms-form-id">
                                        <select name="wpforms_form_id">
                                        <?php foreach ($forms as $form) { ?>
                                            <option value="<?php echo $form->ID ?>" <?php if ($form->ID === $wpforms_id) echo 'selected="true"'; ?>><?php echo $form->post_title ?></option>
                                        <?php } ?>
                                        </select>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php if ( $wpforms_id != "") { echo 'Update this form'; } else { echo 'Save this form'; } ?>">
                                        <input type="hidden" name="action" value="enter-wpforms-form-id">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','wpforms_id_field_nonce'); ?>
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
                                               value="<?php if ( $api_key != "") { echo "....".substr($api_key, -4); } ?>" id="mailerlite-api-key"/>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $api_key != "") { echo 'Update this key'; } else { echo 'Save this key'; } ?>">
                                        <input type="hidden" name="action" value="enter-mailerlite-key">
                                        <?php wp_nonce_field('wpfml_settings_form_nonce','ml_api_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            
                            <?php if ( AdminController::apiKey() != '' ) : ?>
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