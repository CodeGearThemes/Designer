<?php
/**
 * Plugin Name: Designer - Elementor Addons
 * Plugin URI:  https://codegearthemes.com/products/designer
 * Description: Designer is the most-complete addon for Elementor.
 * Version: 1.0.24
 * Author: CodeGearThemes
 * Author URI:  https://codegearthemes.com
 * Text Domain: designer
 * Domain Path: /languages
 * License:  GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('ABSPATH') || exit;

final class Designer{

	/**
	 * Instance of the class.
	 *
	 * @since   1.0.0
	 *
	 * @var   object
	 */
	protected static $instance = null;

    /**
	 * Plugin Version
	 *
	 * @return string
	 * @since 1.0.0
	 *
	 */
	public static function version() {
		return '1.0.24';
	}

    /**
	 * Plugin url
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public static function plugin_url() {
		return trailingslashit(plugin_dir_url(__FILE__));
	}


	/**
	 * Plugin dir
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public static function plugin_dir() {
		return trailingslashit(plugin_dir_path(__FILE__));
	}


    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		require_once __DIR__ . '/autoloader.php';

		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init'], 100);
	}

    /**
	 * Load text domain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain('designer', false, self::plugin_dir() . 'languages/');
	}

    public function init() {

		// Check if Elementor installed and activated
		if ( !did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'required_plugins_notice' ) );
			return;
		}


		do_action('designer/before_loaded');
		Designer\Plugin::instance()->init();
		do_action('designer/after_loaded');
	}

	/**
	 * Show recommended plugins notice.
	 *
	 * @return void
	 */
	public function required_plugins_notice() {
		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		$plugin = 'elementor/elementor.php';

		if ( $this->elementor_installed() ) {
			if ( !current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$admin_message = '<p>' . esc_html__( 'Designer - Requires elementor plugin to be installed.', 'designer' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor', 'designer' ) ) . '</p>';
		} else {
			if ( !current_user_can( 'install_plugins' ) ) {
				return;
			}

			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$admin_message = '<p>' . esc_html__( 'Designer - Requires elementor plugin to be installed.', 'designer' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor', 'designer' ) ) . '</p>';
		} ?>
		<div class="error">
			<?php echo wp_kses_post($admin_message); ?>
		</div>
		<?php
	}


	/**
	 * Check if theme has elementor installed
	 *
	 * @return boolean
	 */
	public function elementor_installed() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}


    /**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

/**
 * Returns the instance.
 *
 * @since  1.0.0
 * @return object
 */
Designer::instance();
