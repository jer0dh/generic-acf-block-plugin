<?php
/**
 * <%= pkg.projectName %>
 *
 * Contains blocks for the specific design of this theme.
 *
 * @link <%= pkg.projectUri %>
 *
 * @package <%= pkg.name %>
 * @since 1.0.0
 *
 * Plugin Name:      <%= pkg.projectName %>
 * Plugin URI:       <%= pkg.projectUri %>
 * Description:      <%= pkg.description %>
 * Version:          <%= pkg.version %>
 * Author:           <%= pkg.author %>
 * Author URI:       <%= pkg.authorUri %>
 * License:          GPL-2.0+
 * License URI:      http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:      <%= pkg.name %>
 * Domain Path:      /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


define( 'GENERIC_ACF_BLOCKS_PLUGIN_VERSION', '<%= pkg.version %>' );
define( 'GENERIC_ACF_BLOCKS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'GENERIC_ACF_BLOCKS_PLUGIN_PATH_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main class for plugin.
 */
class Generic_Acf_Blocks_Plugin {

	/**
	 * Singleton Class.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function get_instance() {
		// If an instance hasn't been created and set to $instance create an instance and set it to $instance.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize plugin if $instance is null.
	 */
	public function __construct() {

		if ( null === self::$instance ) {
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

			// Language file.
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

			add_action( 'plugins_loaded', array( $this, 'load_acf_hooks' ) );

			// Add other hooks and filters.
			// * add_action( 'init', array( $this, 'setup_misc' ) );.

			// Register front end scripts so they can be enqueued if needed.
			add_action( 'wp_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			// Some helper functions that could be placed in class.

			require_once GENERIC_ACF_BLOCKS_PLUGIN_PATH . 'includes/helper-functions.php';
			require_once GENERIC_ACF_BLOCKS_PLUGIN_PATH . 'includes/image-functions.php';

			self::$instance = $this;

			return self::$instance;

		} else {
			return self::$instance;
		}
	}

	/**
	 * Load blocks if ACF plugin is active.
	 */
	public function load_acf_hooks() {

		if ( function_exists( 'acf_register_block_type' ) ) {

			add_action( 'acf/init', array( $this, 'register_acf_block_types' ) );
		}
	}


	/**
	 * Register all the blocks.
	 */
	public function register_acf_block_types() {

		// register a basic content block.
		acf_register_block_type(
			array(
				'name'            => 'basic_content',
				'title'           => __( 'Basic Content' ),
				'description'     => __( 'A section of content' ),
				'render_template' => GENERIC_ACF_BLOCKS_PLUGIN_PATH . 'template-parts/blocks/basic_content/basic_content.php',
				'category'        => 'formatting',
				'icon'            => 'admin-comments',
				'keywords'        => array( 'marketing refresh', 'mr' ),
				'align'           => 'full',
				'supports'        => array(
					'align'  => array( 'full' ),
					'anchor' => true,
				),
			)
		);

		// Cannot just disable align as editor will not show it as full if supports:align is false.
		// https://github.com/AdvancedCustomFields/acf/issues/91.

		// register a Raw HTML Placeholder block.
		acf_register_block_type(
			array(
				'name'            => 'raw_html',
				'title'           => __( 'Raw HTML' ),
				'description'     => __( 'A block that does not strip out anything.  Use with caution' ),
				'render_template' => GENERIC_ACF_BLOCKS_PLUGIN_PATH . 'template-parts/blocks/raw_html/raw_html.php',
				'category'        => 'formatting',
				'icon'            => 'admin-comments',
				'keywords'        => array( 'marketing refresh', 'mr' ),
				'mode'            => 'preview',
				'align'           => 'full',
				'supports'        => array( 'align' => false ),
			)
		);
	}
	/**
	 * Register scripts so they can be enqueued only when needed.
	 */
	public function enqueue_scripts() {

	}

	/**
	 * Editor/Admin scripts.
	 */
	public function admin_enqueue_scripts() {

		wp_enqueue_script( '<%= pkg.name %>-admin', plugins_url( '/js/admin-scripts.js', __FILE__ ), array( 'jquery' ), GENERIC_ACF_BLOCKS_PLUGIN_VERSION, true );

	}

	/**
	 * Activate Plugin
	 */
	public static function activate() {
		// Do nothing.
	} // END public static function activate

	/**
	 * Deactivate the plugin
	 */
	public static function deactivate() {
		// Do nothing.
	} // END public static function deactivate

	/**
	 * Loading textdomain.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'<%= pkg.name %>',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}

if ( class_exists( 'Generic_Acf_Blocks_Plugin' ) ) {

	Generic_Acf_Blocks_Plugin::get_instance();
}
