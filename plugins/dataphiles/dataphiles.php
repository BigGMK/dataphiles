<?php
/**
 * Plugin Name: Dataphiles Bespoke Settings
 * Description: Custom Elementor widgets and settings for Dataphiles websites.
 * Version: 1.0.10
 * Author: Gregor MacKenzie
 * Author URI: https://highland.health
 * Text Domain: dataphiles
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Elementor tested up to: 3.18
 * Elementor Pro tested up to: 3.18
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'DATAPHILES_VERSION', '1.0.10' );
define( 'DATAPHILES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DATAPHILES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main Dataphiles Plugin Class
 */
final class Dataphiles_Plugin {

    /**
     * Plugin instance.
     *
     * @var Dataphiles_Plugin
     */
    private static $instance = null;

    /**
     * Minimum Elementor Version
     *
     * @var string
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     *
     * @var string
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Get plugin instance.
     *
     * @return Dataphiles_Plugin
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
     * Initialize the plugin.
     */
    public function init() {
        // Load Admin Settings
        $this->load_admin();

        // Check if Elementor is installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Register widgets
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

        // Register widget category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        // Register frontend scripts and styles
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_frontend_scripts' ] );
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_frontend_styles' ] );
    }

    /**
     * Load admin settings.
     */
    private function load_admin() {
        require_once DATAPHILES_PLUGIN_DIR . 'includes/class-dataphiles-admin.php';
        new Dataphiles_Admin();
    }

    /**
     * Admin notice for missing Elementor.
     */
    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated for the Elementor widgets to work.', 'dataphiles' ),
            '<strong>' . esc_html__( 'Dataphiles', 'dataphiles' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'dataphiles' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice for minimum Elementor version.
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'dataphiles' ),
            '<strong>' . esc_html__( 'Dataphiles', 'dataphiles' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'dataphiles' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice for minimum PHP version.
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'dataphiles' ),
            '<strong>' . esc_html__( 'Dataphiles', 'dataphiles' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'dataphiles' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Add custom widget category.
     *
     * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
     */
    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'dataphiles',
            [
                'title' => esc_html__( 'Dataphiles', 'dataphiles' ),
                'icon'  => 'fa fa-plug',
            ]
        );
    }

    /**
     * Register widgets.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     */
    public function register_widgets( $widgets_manager ) {
        require_once DATAPHILES_PLUGIN_DIR . 'includes/widgets/class-copyright-widget.php';
        require_once DATAPHILES_PLUGIN_DIR . 'includes/widgets/class-company-registration-widget.php';
        require_once DATAPHILES_PLUGIN_DIR . 'includes/widgets/class-dynamic-text-widget.php';

        $widgets_manager->register( new \Dataphiles\Widgets\Copyright_Widget() );
        $widgets_manager->register( new \Dataphiles\Widgets\Company_Registration_Widget() );
        $widgets_manager->register( new \Dataphiles\Widgets\Dynamic_Text_Widget() );
    }

    /**
     * Register frontend scripts.
     */
    public function register_frontend_scripts() {
        wp_register_script(
            'dataphiles-dynamic-text',
            DATAPHILES_PLUGIN_URL . 'assets/js/dynamic-text.js',
            [],
            DATAPHILES_VERSION,
            true
        );

        // Pass debug setting to JavaScript
        wp_localize_script(
            'dataphiles-dynamic-text',
            'dataphilesSettings',
            [
                'debug' => Dataphiles_Admin::get_setting( 'dynamic_text_debug', false ),
            ]
        );
    }

    /**
     * Register frontend styles.
     */
    public function register_frontend_styles() {
        wp_register_style(
            'dataphiles-dynamic-text',
            DATAPHILES_PLUGIN_URL . 'assets/css/dynamic-text.css',
            [],
            DATAPHILES_VERSION
        );
    }
}

// Initialize the plugin
Dataphiles_Plugin::instance();
