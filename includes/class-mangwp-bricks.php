<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/includes
 * @author     Ivan Nugraha <ivan@mangwp.com>
 */
class Mangwp_Bricks
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mangwp_Bricks_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $mangwp_bricks    The string used to uniquely identify this plugin.
	 */
	protected $mangwp_bricks;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	private $plugin_name;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('MANGWP_BRICKS_VERSION')) {
			$this->version = MANGWP_BRICKS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->mangwp_bricks = 'mangwp-bricks';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mangwp_Bricks_Loader. Orchestrates the hooks of the plugin.
	 * - Mangwp_Bricks_i18n. Defines internationalization functionality.
	 * - Mangwp_Bricks_Admin. Defines all hooks for the admin area.
	 * - Mangwp_Bricks_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mangwp-bricks-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mangwp-bricks-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-mangwp-bricks-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-mangwp-bricks-public.php';

		$this->loader = new Mangwp_Bricks_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mangwp_Bricks_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Mangwp_Bricks_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Mangwp_Bricks_Admin($this->get_mangwp_bricks(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');
		// Add menu item
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
		$this->loader->add_action('init', $plugin_admin, 'disable_gutenberg');
		$this->loader->add_action('init', $plugin_admin, 'add_custom_body_tag_bricks');
		$this->loader->add_action('init', $plugin_admin, 'add_custom_main_tag_bricks');
		$this->loader->add_action('init', $plugin_admin, 'add_custom_header_tag_bricks');
		$this->loader->add_action('init', $plugin_admin, 'add_custom_footer_tag_bricks');

		$this->loader->add_action('admin_init', $plugin_admin, 'mangwp_save_body_attribute_settings');
		$this->loader->add_action('admin_init', $plugin_admin, 'mangwp_save_function_settings');
		$this->loader->add_action('admin_init', $plugin_admin, 'mangwp_save_header_attribute_settings');
		$this->loader->add_action('admin_init', $plugin_admin, 'mangwp_save_footer_attribute_settings');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Mangwp_Bricks_Public($this->get_mangwp_bricks(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		$this->loader->add_action('wp_ajax_save_thumbnail', $plugin_public, 'save_thumbnail_callback');
		$this->loader->add_action('wp_ajax_nopriv_save_thumbnail', $plugin_public, 'save_thumbnail_callback');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_mangwp_bricks()
	{
		return $this->mangwp_bricks;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mangwp_Bricks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
