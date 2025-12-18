<?php
/**
 * Dataphiles Copyright Widget
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
 * Copyright Widget Class
 */
class Copyright_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string
     */
    public function get_name() {
        return 'dataphiles-copyright';
    }

    /**
     * Get widget title.
     *
     * @return string
     */
    public function get_title() {
        return esc_html__( 'Copyright', 'dataphiles' );
    }

    /**
     * Get widget icon.
     *
     * @return string
     */
    public function get_icon() {
        return 'eicon-footer';
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
        return [ 'copyright', 'footer', 'year', 'dataphiles' ];
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
            'start_year',
            [
                'label'       => esc_html__( 'Copyright Start Year', 'dataphiles' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => gmdate( 'Y' ),
                'min'         => 1900,
                'max'         => 2100,
                'description' => esc_html__( 'Enter the year your copyright started. If this year is in the past, a date range will be displayed.', 'dataphiles' ),
            ]
        );

        $this->add_control(
            'company_name',
            [
                'label'       => esc_html__( 'Company Name', 'dataphiles' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Company Name', 'dataphiles' ),
                'placeholder' => esc_html__( 'Enter your company name', 'dataphiles' ),
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'company_url',
            [
                'label'       => esc_html__( 'Company URL', 'dataphiles' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-company.com', 'dataphiles' ),
                'default'     => [
                    'url' => '',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
                'description' => esc_html__( 'Optional: Add a link to your company name.', 'dataphiles' ),
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
                    '{{WRAPPER}} .dataphiles-copyright' => 'text-align: {{VALUE}};',
                ],
            ]
        );

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
                'selector' => '{{WRAPPER}} .dataphiles-copyright',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Text Color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-copyright' => 'color: {{VALUE}};',
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
                'label'     => esc_html__( 'Link Color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-copyright a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label'     => esc_html__( 'Link Hover Color', 'dataphiles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dataphiles-copyright a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Calculate the copyright year display.
     *
     * @param int $start_year The copyright start year.
     * @return string
     */
    private function get_copyright_year( $start_year ) {
        $current_year = (int) gmdate( 'Y' );
        $start_year   = (int) $start_year;

        // If start year is current year or in the future, return just the current year
        if ( $start_year >= $current_year ) {
            return (string) $current_year;
        }

        // If start year is in the past, return range format
        return $start_year . '-' . $current_year;
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $start_year   = ! empty( $settings['start_year'] ) ? $settings['start_year'] : gmdate( 'Y' );
        $company_name = ! empty( $settings['company_name'] ) ? $settings['company_name'] : '';
        $company_url  = ! empty( $settings['company_url']['url'] ) ? $settings['company_url']['url'] : '';

        $year_display = $this->get_copyright_year( $start_year );

        // Build company name output
        $company_output = esc_html( $company_name );
        if ( ! empty( $company_url ) ) {
            $target = ! empty( $settings['company_url']['is_external'] ) ? ' target="_blank"' : '';
            $nofollow = ! empty( $settings['company_url']['nofollow'] ) ? ' rel="nofollow"' : '';
            $company_output = sprintf(
                '<a href="%s"%s%s>%s</a>',
                esc_url( $company_url ),
                $target,
                $nofollow,
                esc_html( $company_name )
            );
        }

        // Output the copyright text
        printf(
            '<div class="dataphiles-copyright">&copy; %s %s. %s</div>',
            esc_html( $year_display ),
            $company_output, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above
            esc_html__( 'All rights reserved.', 'dataphiles' )
        );
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        ?>
        <#
        var currentYear = new Date().getFullYear();
        var startYear = settings.start_year || currentYear;
        var yearDisplay = '';

        if ( parseInt( startYear ) >= currentYear ) {
            yearDisplay = currentYear.toString();
        } else {
            yearDisplay = startYear + '-' + currentYear;
        }

        var companyName = settings.company_name || '';
        var companyUrl = settings.company_url.url || '';
        var companyOutput = '';

        if ( companyUrl ) {
            var target = settings.company_url.is_external ? ' target="_blank"' : '';
            var nofollow = settings.company_url.nofollow ? ' rel="nofollow"' : '';
            companyOutput = '<a href="' + companyUrl + '"' + target + nofollow + '>' + companyName + '</a>';
        } else {
            companyOutput = companyName;
        }
        #>
        <div class="dataphiles-copyright">
            &copy; {{{ yearDisplay }}} {{{ companyOutput }}}. <?php echo esc_html__( 'All rights reserved.', 'dataphiles' ); ?>
        </div>
        <?php
    }
}
