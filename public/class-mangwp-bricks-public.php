<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/public
 * @author     Ivan Nugraha <ivan@mangwp.com>
 */
class Mangwp_Bricks_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $mangwp_bricks    The ID of this plugin.
	 */
	private $mangwp_bricks;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $mangwp_bricks       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($mangwp_bricks, $version)
	{

		$this->mangwp_bricks = $mangwp_bricks;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mangwp_Bricks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mangwp_Bricks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->mangwp_bricks, plugin_dir_url(__FILE__) . 'css/mangwp-bricks-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mangwp_Bricks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mangwp_Bricks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$options = get_option($this->mangwp_bricks);
		$mangwp_screenshot_enabled = isset($options['mangwp_screenshot']) ? $options['mangwp_screenshot'] : false;
		if ($mangwp_screenshot_enabled && is_singular('bricks_template') && !bricks_is_builder() && is_user_logged_in()) {
			wp_enqueue_script('screenshot', plugin_dir_url(__FILE__) . 'js/mangwp-bricks-screenshot.js', array('jquery'), $this->version, true);
			wp_enqueue_script('html2canvas', plugin_dir_url(__FILE__) . 'js/html2canvas.min.js', array('bricks-scripts'), $this->version, true);
			wp_enqueue_style('lightbox2-css', plugin_dir_url(__FILE__) .'css/lightbox.min.css', array(), $this->version, 'all');
			wp_enqueue_script('lightbox2-js',  plugin_dir_url(__FILE__) . 'js/lightbox.min.js', array('jquery', 'bricks-scripts'), $this->version, true);
		};
		wp_enqueue_script($this->mangwp_bricks, plugin_dir_url(__FILE__) . 'js/mangwp-bricks-public.js', array('jquery'), $this->version, true);
		wp_localize_script('screenshot', 'wp_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('custom_nonce'),
			'post_id' => get_the_ID(),
		));
	}

	public function save_thumbnail_callback()
	{
		error_log('AJAX Request Received'); // Check if the AJAX request is received

		// Verify the nonce
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'custom_nonce')) {
			wp_send_json_error('Invalid nonce');
		}

		// Get the post ID
		$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

		// Check if the current user has the capability to edit this post
		if (!current_user_can('edit_post', $post_id)) {
			wp_send_json_error('Permission denied');
		}

		// Process and save the image data
		$image_data = isset($_POST['image_data']) ? sanitize_text_field($_POST['image_data']) : '';

		// Decode the base64-encoded image data
		$decoded_image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image_data));

		// Generate a unique filename for the image
		$filename = 'thumbnail-template-' . $post_id;

		// Save the image to the uploads directory
		$upload_dir = wp_upload_dir();
		$upload_path = $upload_dir['path'] . '/' . $filename . '.png';
		file_put_contents($upload_path, $decoded_image_data);

		// Create attachment data
		$attachment_data = array(
			'post_mime_type' => 'image/png',
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit',
		);

		// Insert the attachment
		$attachment_id = wp_insert_attachment($attachment_data, $upload_path, $post_id);

		if (!is_wp_error($attachment_id)) {
			// Set post thumbnail
			set_post_thumbnail($post_id, $attachment_id);

			// Generate attachment metadata
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$attachment_metadata = wp_generate_attachment_metadata($attachment_id, $upload_path);
			wp_update_attachment_metadata($attachment_id, $attachment_metadata);
			wp_send_json_success(array('image_url' => $upload_path)); // Provide the actual path to the saved image
		} else {
			$error_message = 'Error saving thumbnail: ' . $attachment_id->get_error_message();
			error_log($error_message); // Log the specific error message
			wp_send_json_error($error_message);
		}
	}
}
