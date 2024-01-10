<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/admin
 * @author     Ivan Nugraha <ivan@mangwp.com>
 */

// Instantiate your class

class Mangwp_Bricks_Admin
{
	private $mangwp_bricks;
	private $version;

	public function __construct($mangwp_bricks, $version)
	{
		$this->mangwp_bricks = $mangwp_bricks;
		$this->version = $version;
	}

	public function enqueue_styles()
	{
		wp_enqueue_style($this->mangwp_bricks, plugin_dir_url(__FILE__) . 'css/mangwp-bricks-admin.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script($this->mangwp_bricks, plugin_dir_url(__FILE__) . 'js/mangwp-bricks-admin.js', array('jquery'), $this->version, true);
	}

	public function add_plugin_admin_menu()
	{
		add_menu_page(
			__('MangWP Admin Page', 'mangwp'),
			__('MangWP Bricks', 'mangwp'),
			'manage_options',
			'mangwp',
			array($this, 'admin_page_callback'),
			'dashicons-admin-generic',
			20
		);
		add_submenu_page(
			'mangwp',
			__('Submenu Page', 'mangwp'),
			__('Submenu', 'mangwp'),
			'manage_options',
			'mangwp-submenu',
			array($this, 'admin_html_to_json_page_callback')
		);
	}

	public function admin_page_callback()
	{
		include_once('partials/' . $this->mangwp_bricks . '-admin.php');
	}

	public function admin_html_to_json_page_callback()
	{
		include_once('partials/' . $this->mangwp_bricks . '-html-to-json-admin.php');
	}

	public function validate($input)
	{
		$options = get_option($this->mangwp_bricks);
		$options['mangwp_screenshot'] = isset($input['mangwp_screenshot']) ? 1 : 0;

		// Disable Gutenberg validation
		if (isset($input['mangwp_disable_gutenberg']) && is_array($input['mangwp_disable_gutenberg'])) {
			$options['mangwp_disable_gutenberg'] = array_map('sanitize_text_field', $input['mangwp_disable_gutenberg']); // Sanitize text field
		} else {
			$options['mangwp_disable_gutenberg'] = array();
		};
		//Custom Main Tag//
		$options['mangwp_body_attribute'] = isset($input['mangwp_body_attribute']) ? 1 : 0;
		$options['mangwp_main_attribute'] = isset($input['mangwp_main_attribute']) ? 1 : 0;
		$options['mangwp_header_attribute'] = isset($input['mangwp_header_attribute']) ? 1 : 0;
		$options['mangwp_footer_attribute'] = isset($input['mangwp_footer_attribute']) ? 1 : 0;

		// Main Attribute values validation

		return $options;
	}
	

	function mangwp_save_body_attribute_settings()
	{
		if (isset($_POST['mangwp_body_attributes'])) {
			$mangwp_body_attributes = $_POST['mangwp_body_attributes'];
			$sanitizedAttributes = array();

			foreach ($mangwp_body_attributes as $attribute) {
				if (!empty($attribute['body_name']) && isset($attribute['body_value'])) {
					$sanitizedAttributes[] = array(
						'body_name' => sanitize_text_field($attribute['body_name']),
						'body_value' => sanitize_text_field($attribute['body_value']),
					);
				}
			}
			update_option('mangwp_body_attributes', $sanitizedAttributes);
			error_log('Received data: ' . print_r($_POST['mangwp_body_attributes'], true));
		}
	}
	function mangwp_save_function_settings()
	{
		if (isset($_POST['mangwp_main_attributes'])) {
			$mangwp_main_attributes = $_POST['mangwp_main_attributes'];
			$sanitizedAttributes = array();

			foreach ($mangwp_main_attributes as $attribute) {
				if (!empty($attribute['main_name']) && isset($attribute['main_value'])) {
					$sanitizedAttributes[] = array(
						'main_name' => sanitize_text_field($attribute['main_name']),
						'main_value' => sanitize_text_field($attribute['main_value']),
					);
				}
			}
			update_option('mangwp_main_attributes', $sanitizedAttributes);
			error_log('Received data: ' . print_r($_POST['mangwp_main_attributes'], true));
		}
	}
	function mangwp_save_header_attribute_settings()
	{
		if (isset($_POST['mangwp_header_attributes'])) {
			$mangwp_header_attributes = $_POST['mangwp_header_attributes'];
			$sanitizedAttributes = array();

			foreach ($mangwp_header_attributes as $attribute) {
				if (!empty($attribute['header_name']) && isset($attribute['header_value'])) {
					$sanitizedAttributes[] = array(
						'header_name' => sanitize_text_field($attribute['header_name']),
						'header_value' => sanitize_text_field($attribute['header_value']),
					);
				}
			}
			update_option('mangwp_header_attributes', $sanitizedAttributes);
			error_log('Received data: ' . print_r($_POST['mangwp_header_attributes'], true));
		}
	}
	function mangwp_save_footer_attribute_settings()
	{
		if (isset($_POST['mangwp_footer_attributes'])) {
			$mangwp_footer_attributes = $_POST['mangwp_footer_attributes'];
			$sanitizedAttributes = array();

			foreach ($mangwp_footer_attributes as $attribute) {
				if (!empty($attribute['footer_name']) && isset($attribute['footer_value'])) {
					$sanitizedAttributes[] = array(
						'footer_name' => sanitize_text_field($attribute['footer_name']),
						'footer_value' => sanitize_text_field($attribute['footer_value']),
					);
				}
			}
			update_option('mangwp_footer_attributes', $sanitizedAttributes);
			error_log('Received data: ' . print_r($_POST['mangwp_footer_attributes'], true));
		}
	}
	public function options_update()
	{
		register_setting($this->mangwp_bricks, $this->mangwp_bricks, array(
			'sanitize_callback' => array($this, 'validate'),
		));
	}

	public function disable_gutenberg()
	{
		$options = get_option($this->mangwp_bricks);
		$mangwp_disable_gutenberg_enabled = isset($options['mangwp_disable_gutenberg']) ? $options['mangwp_disable_gutenberg'] : array();

		if ($mangwp_disable_gutenberg_enabled) {
			// Disable Gutenberg for selected post types
			if (!current_user_can('edit_posts')) {
				return;
			}

			// Get the post types that have Gutenberg disabled
			$disabled_post_types = isset($mangwp_disable_gutenberg_enabled) ? $mangwp_disable_gutenberg_enabled : array();

			// Add filter for each disabled post type
			foreach ($disabled_post_types as $post_type_name => $is_disabled) {
				if ($is_disabled) {
					add_filter("use_block_editor_for_post_type", function ($use_block_editor, $post_type) use ($post_type_name) {
						if ($post_type === $post_type_name) {
							return false;
						}
						return $use_block_editor;
					}, 10, 2);
					remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
				}
			}
		}
	}
	
	public function add_custom_body_tag_bricks()
	{
		$options = get_option($this->mangwp_bricks);
		$mangwp_body_attributes = get_option('mangwp_body_attributes', array());
		$mangwp_body_attribute_enabled = isset($options['mangwp_body_attribute']) ? $options['mangwp_body_attribute'] : false;
		if ($mangwp_body_attribute_enabled) {
			add_filter('bricks/body/attributes', function ($attributes) use ($mangwp_body_attributes) {
				foreach ($mangwp_body_attributes as $attribute) {
					// Check if the keys exist before accessing them
					$bodyName = isset($attribute['body_name']) ? $attribute['body_name'] : '';
					$bodyValue = isset($attribute['body_value']) ? $attribute['body_value'] : '';

					if (!empty($bodyName) && isset($bodyValue)) {
						if ($bodyName === 'class' && isset($attributes['class'])) {
							// If the bodyname is 'class', merge the new class with existing classes
							$attributes['class'] = array_merge($attributes['class'], explode(' ', $bodyValue));
						} else {
							// Add other attributes directly
							$attributes[$bodyName] = $bodyValue;
						}
					}
				}
				return $attributes;
			});
		}
	}
	public function add_custom_main_tag_bricks()
	{
		$options = get_option($this->mangwp_bricks);
		$mangwp_main_attributes = get_option('mangwp_main_attributes', array());
		$mangwp_main_attribute_enabled = isset($options['mangwp_main_attribute']) ? $options['mangwp_main_attribute'] : false;
		if ($mangwp_main_attribute_enabled) {
			add_filter('bricks/content/attributes', function ($attributes) use ($mangwp_main_attributes) {
				foreach ($mangwp_main_attributes as $attribute) {
					// Check if the keys exist before accessing them
					$mainName = isset($attribute['main_name']) ? $attribute['main_name'] : '';
					$mainValue = isset($attribute['main_value']) ? $attribute['main_value'] : '';

					if (!empty($mainName) && isset($mainValue)) {
						if ($mainName === 'class' && isset($attributes['class'])) {
							// If the main_name is 'class', merge the new class with existing classes
							$attributes['class'] = array_merge($attributes['class'], explode(' ', $mainValue));
						} else {
							// Add other attributes directly
							$attributes[$mainName] = $mainValue;
						}
					}
				}
				return $attributes;
			});
		}
	}
	public function add_custom_header_tag_bricks()
	{
		$options = get_option($this->mangwp_bricks);
		$mangwp_header_attributes = get_option('mangwp_header_attributes', array());
		$mangwp_header_attribute_enabled = isset($options['mangwp_header_attribute']) ? $options['mangwp_header_attribute'] : false;
		if ($mangwp_header_attribute_enabled) {
			add_filter('bricks/header/attributes', function ($attributes) use ($mangwp_header_attributes) {
				foreach ($mangwp_header_attributes as $attribute) {
					// Check if the keys exist before accessing them
					$headerName = isset($attribute['header_name']) ? $attribute['header_name'] : '';
					$headerValue = isset($attribute['header_value']) ? $attribute['header_value'] : '';

					if (!empty($headerName) && isset($headerValue)) {
						if ($headerName === 'class' && isset($attributes['class'])) {
							// If the headername is 'class', merge the new class with existing classes
							$attributes['class'] = array_merge($attributes['class'], explode(' ', $headerValue));
						} else {
							// Add other attributes directly
							$attributes[$headerName] = $headerValue;
						}
					}
				}
				return $attributes;
			});
		}
	}
	public function add_custom_footer_tag_bricks()
	{
		$options = get_option($this->mangwp_bricks);
		$mangwp_footer_attributes = get_option('mangwp_footer_attributes', array());
		$mangwp_footer_attribute_enabled = isset($options['mangwp_footer_attribute']) ? $options['mangwp_footer_attribute'] : false;
		if ($mangwp_footer_attribute_enabled) {
			add_filter('bricks/footer/attributes', function ($attributes) use ($mangwp_footer_attributes) {
				foreach ($mangwp_footer_attributes as $attribute) {
					// Check if the keys exist before accessing them
					$footerName = isset($attribute['footer_name']) ? $attribute['footer_name'] : '';
					$footerValue = isset($attribute['footer_value']) ? $attribute['footer_value'] : '';

					if (!empty($footerName) && isset($footerValue)) {
						if ($footerName === 'class' && isset($attributes['class'])) {
							// If the footername is 'class', merge the new class with existing classes
							$attributes['class'] = array_merge($attributes['class'], explode(' ', $footerValue));
						} else {
							// Add other attributes directly
							$attributes[$footerName] = $footerValue;
						}
					}
				}
				return $attributes;
			});
		}
	}
}

