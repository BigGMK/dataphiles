<?php
/**
 * Dataphiles Admin Settings Page
 *
 * @package Dataphiles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Dataphiles Admin Class
 */
class Dataphiles_Admin {

    /**
     * Option name for settings.
     *
     * @var string
     */
    const OPTION_NAME = 'dataphiles_settings';

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
    }

    /**
     * Add admin menu page.
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'Dataphiles Settings', 'dataphiles' ),
            __( 'Dataphiles', 'dataphiles' ),
            'manage_options',
            'dataphiles-settings',
            [ $this, 'render_settings_page' ],
            'dashicons-analytics',
            80
        );
    }

    /**
     * Register settings.
     */
    public function register_settings() {
        register_setting(
            'dataphiles_settings_group',
            self::OPTION_NAME,
            [
                'type'              => 'array',
                'sanitize_callback' => [ $this, 'sanitize_settings' ],
                'default'           => $this->get_default_settings(),
            ]
        );

        // General Settings Section
        add_settings_section(
            'dataphiles_general_section',
            __( 'General Settings', 'dataphiles' ),
            [ $this, 'render_general_section' ],
            'dataphiles-settings'
        );

        // Dynamic Text Debug Logging
        add_settings_field(
            'dynamic_text_debug',
            __( 'Dynamic Text Debug Logging', 'dataphiles' ),
            [ $this, 'render_dynamic_text_debug_field' ],
            'dataphiles-settings',
            'dataphiles_general_section'
        );
    }

    /**
     * Get default settings.
     *
     * @return array
     */
    private function get_default_settings() {
        return [
            'dynamic_text_debug' => false,
        ];
    }

    /**
     * Sanitize settings.
     *
     * @param array $input Input settings.
     * @return array
     */
    public function sanitize_settings( $input ) {
        $sanitized = [];

        // Dynamic Text Debug Logging
        $sanitized['dynamic_text_debug'] = ! empty( $input['dynamic_text_debug'] );

        return $sanitized;
    }

    /**
     * Render Dynamic Text Debug field.
     */
    public function render_dynamic_text_debug_field() {
        $settings = get_option( self::OPTION_NAME, $this->get_default_settings() );
        $checked  = ! empty( $settings['dynamic_text_debug'] );
        ?>
        <label>
            <input type="checkbox" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[dynamic_text_debug]" value="1" <?php checked( $checked ); ?> />
            <?php esc_html_e( 'Enable debug logging in browser console for the Dynamic Text widget', 'dataphiles' ); ?>
        </label>
        <p class="description">
            <?php esc_html_e( 'When enabled, detailed animation logs will be output to the browser developer console. Useful for troubleshooting.', 'dataphiles' ); ?>
        </p>
        <?php
    }

    /**
     * Enqueue admin styles.
     *
     * @param string $hook Current admin page hook.
     */
    public function enqueue_admin_styles( $hook ) {
        if ( 'toplevel_page_dataphiles-settings' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'dataphiles-admin',
            DATAPHILES_PLUGIN_URL . 'assets/css/admin.css',
            [],
            DATAPHILES_VERSION
        );
    }

    /**
     * Render general section description.
     */
    public function render_general_section() {
        echo '<p>' . esc_html__( 'Configure general Dataphiles plugin settings below.', 'dataphiles' ) . '</p>';
    }

    /**
     * Render settings page.
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Show success message after saving
        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error(
                'dataphiles_messages',
                'dataphiles_message',
                __( 'Settings saved.', 'dataphiles' ),
                'updated'
            );
        }

        settings_errors( 'dataphiles_messages' );
        ?>
        <div class="wrap dataphiles-admin-wrap">
            <h1>
                <?php echo esc_html( get_admin_page_title() ); ?>
                <span class="dataphiles-version"><?php echo esc_html( 'v' . DATAPHILES_VERSION ); ?></span>
            </h1>

            <div class="dataphiles-admin-header">
                <p class="description">
                    <?php esc_html_e( 'Welcome to Dataphiles settings. Configure your plugin options below.', 'dataphiles' ); ?>
                </p>
            </div>

            <form action="options.php" method="post">
                <?php
                settings_fields( 'dataphiles_settings_group' );
                do_settings_sections( 'dataphiles-settings' );
                submit_button( __( 'Save Settings', 'dataphiles' ) );
                ?>
            </form>

            <div class="dataphiles-admin-footer">
                <h3><?php esc_html_e( 'Available Widgets', 'dataphiles' ); ?></h3>
                <ul>
                    <li>
                        <strong><?php esc_html_e( 'Copyright Widget', 'dataphiles' ); ?></strong> -
                        <?php esc_html_e( 'Display dynamic copyright text with customizable date range and company name.', 'dataphiles' ); ?>
                    </li>
                    <li>
                        <strong><?php esc_html_e( 'Company Registration Widget', 'dataphiles' ); ?></strong> -
                        <?php esc_html_e( 'Display company registered number and registered office address.', 'dataphiles' ); ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Get a specific setting value.
     *
     * @param string $key     Setting key.
     * @param mixed  $default Default value.
     * @return mixed
     */
    public static function get_setting( $key, $default = null ) {
        $settings = get_option( self::OPTION_NAME, [] );
        return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
    }
}
