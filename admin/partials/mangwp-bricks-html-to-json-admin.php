<?php

/**
 * Provide a admin main page area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/admin/partials
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}?>
<h2>Plugin Name <?php esc_attr_e('Options', 'mangwp_bricks'); ?></h2>
