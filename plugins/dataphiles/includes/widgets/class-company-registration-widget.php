<?php
/**
 * Dataphiles Company Registration Widget
 *
 * @package Dataphiles
 */

namespace Dataphiles\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Company Registration Widget Class
 */
class Company_Registration_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string
     */
    public function get_name() {
        return 'dataphiles-company-registration';
    }

    /**
     * Get widget title.
     *
     * @return string
     */
    public function get_title() {
        return esc_html__( 'Company Registration', 'dataphiles' );
    }

    /**
     * Get widget icon.
     *
     * @return string
     */
    public function get_icon() {
        return 'eicon-document-file';
    }

    /**
     * Get widget categories.
     *
     * @return array
     */
    public function get_categories() {
        return [ 'dataphiles', 'general' ];
    }

    /**
     * Get widget keywords.
     *
     * @return array
     */
    public function get_keywords() {
        return [ 'company', 'registration', 'registered', 'office', 'number', 'footer', 'dataphiles' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'dataphiles' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'registered_number',
            [
                'label'       => esc_html__( 'Registered number', 'dataphiles' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => esc_html__( 'e.g. 04599161', 'dataphiles' ),
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'registered_office',
            [
                'label'       => esc_html__( 'Registered office', 'dataphiles' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '',
                'placeholder' => esc_html__( 'e.g. Bank Chambers, 25 Crossgate, Otley, West Yorkshire, LS21 1BE', 'dataphiles' ),
                'rows'        => 3,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__( 'Alignment', 'dataphiles' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'dataphiles' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'dataphiles' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'dataphiles' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-company-registration' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Additional Text Section
        $this->start_controls_section(
            'section_additional_text',
            [
                'label' => esc_html__( 'Additional text', 'dataphiles' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_text_before',
            [
                'label'        => esc_html__( 'Text before', 'dataphiles' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'None', 'dataphiles' ),
                'label_on'     => esc_html__( 'Custom', 'dataphiles' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'text_before',
            [
                'label'       => esc_html__( 'Content', 'dataphiles' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => '',
                'placeholder' => esc_html__( 'Optional text to appear before the registration info', 'dataphiles' ),
                'description' => esc_html__( 'This text will appear inline before the registration info. You can include links.', 'dataphiles' ),
                'condition'   => [
                    'show_text_before' => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->add_control(
            'show_text_after',
            [
                'label'        => esc_html__( 'Text after', 'dataphiles' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => esc_html__( 'None', 'dataphiles' ),
                'label_on'     => esc_html__( 'Custom', 'dataphiles' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'text_after',
            [
                'label'       => esc_html__( 'Content', 'dataphiles' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => '',
                'placeholder' => esc_html__( 'Optional text to appear after the registration info', 'dataphiles' ),
                'description' => esc_html__( 'This text will appear inline after the registration info. You can include links.', 'dataphiles' ),
                'condition'   => [
                    'show_text_after' => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'dataphiles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .dataphiles-company-registration',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Text color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-company-registration' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_heading',
            [
                'label'     => esc_html__( 'Link', 'dataphiles' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__( 'Link color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-company-registration a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label'     => esc_html__( 'Link hover color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-company-registration a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Convert block-level content to inline by stripping paragraph tags.
     *
     * @param string $content The content to convert.
     * @return string
     */
    private function make_inline( $content ) {
        if ( empty( $content ) ) {
            return '';
        }

        // Remove paragraph tags but keep their content
        $content = preg_replace( '/<p[^>]*>/', '', $content );
        $content = str_replace( '</p>', ' ', $content );

        // Remove other block-level elements
        $content = preg_replace( '/<(div|h[1-6]|ul|ol|li|blockquote)[^>]*>/', '', $content );
        $content = preg_replace( '/<\/(div|h[1-6]|ul|ol|li|blockquote)>/', ' ', $content );

        // Clean up extra whitespace
        $content = preg_replace( '/\s+/', ' ', $content );

        return trim( $content );
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $registered_number = ! empty( $settings['registered_number'] ) ? $settings['registered_number'] : '';
        $registered_office = ! empty( $settings['registered_office'] ) ? $settings['registered_office'] : '';
        $text_before       = ! empty( $settings['text_before'] ) ? $this->make_inline( $settings['text_before'] ) : '';
        $text_after        = ! empty( $settings['text_after'] ) ? $this->make_inline( $settings['text_after'] ) : '';

        // Build before text output
        $before_output = '';
        if ( ! empty( $text_before ) ) {
            $before_output = '<span class="dataphiles-registration-before">' . wp_kses_post( $text_before ) . '</span> ';
        }

        // Build after text output
        $after_output = '';
        if ( ! empty( $text_after ) ) {
            $after_output = ' <span class="dataphiles-registration-after">' . wp_kses_post( $text_after ) . '</span>';
        }

        // Build main content
        $parts = [];

        if ( ! empty( $registered_number ) ) {
            $parts[] = sprintf(
                '%s %s',
                esc_html__( 'Registered number:', 'dataphiles' ),
                esc_html( $registered_number )
            );
        }

        if ( ! empty( $registered_office ) ) {
            $parts[] = sprintf(
                '%s %s',
                esc_html__( 'Registered office:', 'dataphiles' ),
                esc_html( $registered_office )
            );
        }

        $main_content = implode( '. ', $parts );
        if ( ! empty( $main_content ) ) {
            $main_content .= '.';
        }

        // Output the registration text
        printf(
            '<div class="dataphiles-company-registration">%s%s%s</div>',
            $before_output, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped with wp_kses_post above
            $main_content, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above
            $after_output // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped with wp_kses_post above
        );
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        ?>
        <#
        var registeredNumber = settings.registered_number || '';
        var registeredOffice = settings.registered_office || '';

        // Helper function to strip block-level tags for inline display
        function makeInline( content ) {
            if ( ! content ) return '';
            // Remove paragraph tags
            content = content.replace( /<p[^>]*>/gi, '' );
            content = content.replace( /<\/p>/gi, ' ' );
            // Remove other block elements
            content = content.replace( /<(div|h[1-6]|ul|ol|li|blockquote)[^>]*>/gi, '' );
            content = content.replace( /<\/(div|h[1-6]|ul|ol|li|blockquote)>/gi, ' ' );
            // Clean up whitespace
            content = content.replace( /\s+/g, ' ' ).trim();
            return content;
        }

        var textBefore = settings.text_before ? makeInline( settings.text_before ) : '';
        var textAfter = settings.text_after ? makeInline( settings.text_after ) : '';

        var beforeOutput = textBefore ? '<span class="dataphiles-registration-before">' + textBefore + '</span> ' : '';
        var afterOutput = textAfter ? ' <span class="dataphiles-registration-after">' + textAfter + '</span>' : '';

        var parts = [];
        if ( registeredNumber ) {
            parts.push( '<?php echo esc_js( __( 'Registered number:', 'dataphiles' ) ); ?> ' + registeredNumber );
        }
        if ( registeredOffice ) {
            parts.push( '<?php echo esc_js( __( 'Registered office:', 'dataphiles' ) ); ?> ' + registeredOffice );
        }

        var mainContent = parts.join( '. ' );
        if ( mainContent ) {
            mainContent += '.';
        }
        #>
        <div class="dataphiles-company-registration">
            {{{ beforeOutput }}}{{{ mainContent }}}{{{ afterOutput }}}
        </div>
        <?php
    }
}
