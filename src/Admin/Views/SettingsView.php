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
    public function __construct($api_key, $wpform_id, $ml_group_id)
    {
        $this->view($api_key, $wpform_id, $ml_group_id);
    }

    /**
     * Output view
     *
     * @access      private
     * @return      void
     */
    private function view($api_key, $wpform_id, $ml_group_id)
    {
        $groups = [];
        if ( AdminController::apiKey() != '' ) {
            $API = new MailerLiteApi(AdminController::apiKey());
            $groups = $API->getGroups([
                'limit' => AdminController::FIRST_GROUP_LOAD
            ]);
        }

        ?>
        <div class="wrap columns-2 dd-wrap">
            <h1><?php echo __( 'Plugin settings', 'mailerlite' ); ?></h1>

            <div class="metabox-holder has-right-sidebar">
                <div id="post-body">
                    <div id="post-body-content" class="mailerlite-activate">

                        <table class="form-table">
                            <tr>
                                <th valign="top">
                                    <label for="mailerlite-api-key">Enter an API key</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-mailerlite-key">
                                        <input type="text" name="mailerlite_key" class="regular-text" placeholder="API-key"
                                               value="<?php if ( $api_key != "") { echo "....".substr($api_key, -4); } ?>" id="mailerlite-api-key"/>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $api_key != "") { echo 'Update this key'; } else { echo 'Save this key'; } ?>">
                                        <input type="hidden" name="action" value="enter-mailerlite-key">
                                        <?php wp_nonce_field('ml_form_nonce','ml_api_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>

                            <tr>
                                <th valign="top">
                                    <label for="wpform-id">WPForm ID to send to MailerLite</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-wpform-id">
                                        <input type="text" name="wpform_id" class="regular-text" placeholder="WPForm-ID"
                                               value="<?php if ( $wpform_id != "") { echo $wpform_id; } ?>" id="wpform-id"/>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $wpform_id != "") { echo 'Update this ID'; } else { echo 'Save this ID'; } ?>">
                                        <input type="hidden" name="action" value="enter-wpform-id">
                                        <?php wp_nonce_field('ml_form_nonce','wpform_id_field_nonce'); ?>
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
                                            <?php
                                            foreach ($groups as $group) {
                                                echo "<option value='$group->$id'" . ($group->$id === $ml_group_id) ? " selected" : "" . ">$group->$name</option>\n";
                                            }
                                            ?>
                                        </select>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $ml_group_id != "") { echo 'Update this group'; } else { echo 'Save this group'; } ?>">
                                        <input type="hidden" name="action" value="enter-mailerlite-group-id">
                                        <?php wp_nonce_field('ml_form_nonce','ml_group_id_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <tr>
                                <th valign="top">
                                    <label for="wpform-id">Enter the WPForm ID</label>
                                </th>
                                <td>
                                    <form action="" method="post" id="enter-wpform-id">
                                        <input type="text" name="wpform_id" class="regular-text" placeholder="WPForm-ID"
                                               value="<?php if ( $wpform_id != "") { echo $wpform_id; } ?>" id="wpform-id"/>

                                        <input type="submit" name="submit" id="submit" class="button button-primary"
                                               value="<?php  if ( $wpform_id != "") { echo 'Update this ID'; } else { echo 'Save this ID'; } ?>">
                                        <input type="hidden" name="action" value="enter-wpform-id">
                                        <?php wp_nonce_field('ml_form_nonce','wpform_id_field_nonce'); ?>
                                    </form>
                                </td>
                            </tr>
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