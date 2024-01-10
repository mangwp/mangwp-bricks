<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/admin/partials
 */

if (!defined('ASBATH')) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Plugin Name <?php esc_attr_e('Options', 'mangwp_bricks'); ?></h2>

    <form method="post" name="<?php echo $this->mangwp_bricks; ?>" action="options.php">
        <?php
        //Grab all options
        $options = get_option($this->mangwp_bricks);
        $example_select = (isset($options['example_select']) && !empty($options['example_select'])) ? esc_attr($options['example_select']) : '1';
        $example_text = (isset($options['example_text']) && !empty($options['example_text'])) ? esc_attr($options['example_text']) : 'default';
        $example_textarea = (isset($options['example_textarea']) && !empty($options['example_textarea'])) ? sanitize_textarea_field($options['example_textarea']) : 'default';
        $example_checkbox = (isset($options['example_checkbox']) && !empty($options['example_checkbox'])) ? 1 : 0;

        settings_fields($this->mangwp_bricks);
        do_settings_sections($this->mangwp_bricks);

        ?>

        <!-- Select -->
        <fieldset>
            <p><?php esc_attr_e('Example Select.', 'mangwp_bricks'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Select', 'mangwp_bricks'); ?></span>
            </legend>
            <label for="example_select">
                <select name="<?php echo $this->mangwp_bricks; ?>[example_select]" id="<?php echo $this->mangwp_bricks; ?>-example_select">
                    <option <?php if ($example_select == 'first') echo 'selected="selected"'; ?> value="first">First</option>
                    <option <?php if ($example_select == 'second') echo 'selected="selected"'; ?> value="second">Second</option>
                </select>
            </label>
        </fieldset>

        <!-- Text -->
        <fieldset>
            <p><?php esc_attr_e('Example Text.', 'mangwp_bricks'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Text', 'mangwp_bricks'); ?></span>
            </legend>
            <input type="text" class="example_text" id="<?php echo $this->mangwp_bricks; ?>-example_text" name="<?php echo $this->mangwp_bricks; ?>[example_text]" value="<?php if (!empty($example_text)) echo $example_text;
                                                                                                                                                                        else echo 'default'; ?>" />
        </fieldset>

        <!-- Textarea -->
        <fieldset>
            <p><?php esc_attr_e('Example Text.', 'mangwp_bricks'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Text', 'mangwp_bricks'); ?></span>
            </legend>
            <textarea class="example_textarea" id="<?php echo $this->mangwp_bricks; ?>-example_textarea" name="<?php echo $this->mangwp_bricks; ?>[example_textarea]" rows="4" cols="50">
             <?php if (!empty($example_textarea)) echo $example_textarea;
                else echo 'default'; ?>
         </textarea>
        </fieldset>

        <!-- Checkbox -->
        <fieldset>
            <p><?php esc_attr_e('Example Checkbox.', 'mangwp_bricks'); ?></p>
            <legend class="example-Checkbox">
                <span><?php esc_attr_e('Example Checkbox', 'mangwp_bricks'); ?></span>
            </legend>
            <label for="<?php echo $this->mangwp_bricks; ?>-example_checkbox">
                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-example_checkbox" name="<?php echo $this->mangwp_bricks; ?>[example_checkbox]" value="1" <?php checked($example_checkbox, 1); ?> />
                <span><?php esc_attr_e('Example Checkbox', 'mangwp_bricks'); ?></span>
            </label>
        </fieldset>

        <?php submit_button(__('Save all changes', 'mangwp_bricks'), 'primary', 'submit', TRUE); ?>
    </form>
</div>