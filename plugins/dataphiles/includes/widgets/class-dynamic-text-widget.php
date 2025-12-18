<?php
/**
 * Dataphiles Dynamic Text Widget
 *
 * @package Dataphiles
 * @since 1.0.3
 */

namespace Dataphiles\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic Text Widget class.
 *
 * Displays rotating impact text with sublines using drop-in/fade animations.
 */
class Dynamic_Text_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dataphiles-dynamic-text';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dataphiles Dynamic Text', 'dataphiles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-animation-text';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dataphiles' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'text', 'dynamic', 'animation', 'rotating', 'headline', 'impact', 'fade', 'drop', 'svg' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return [ 'dataphiles-dynamic-text' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return [ 'dataphiles-dynamic-text' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->register_content_controls();
		$this->register_animation_controls();
		$this->register_style_controls();
	}

	/**
	 * Register content controls.
	 */
	private function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'content_type',
			[
				'label'   => esc_html__( 'Impact Content Type', 'dataphiles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'text'  => esc_html__( 'Text', 'dataphiles' ),
					'image' => esc_html__( 'Image/SVG', 'dataphiles' ),
				],
				'default' => 'text',
			]
		);

		$repeater->add_control(
			'impact_text',
			[
				'label'       => esc_html__( 'Impact Text', 'dataphiles' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Impact', 'dataphiles' ),
				'placeholder' => esc_html__( 'Enter impact word', 'dataphiles' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'content_type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'impact_image',
			[
				'label'     => esc_html__( 'Impact Image/SVG', 'dataphiles' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => '',
				],
				'condition' => [
					'content_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'subline_text',
			[
				'label'       => esc_html__( 'Subline Text', 'dataphiles' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Subline', 'dataphiles' ),
				'placeholder' => esc_html__( 'Enter subline text', 'dataphiles' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'custom_display_duration',
			[
				'label'       => esc_html__( 'Custom Display Duration (ms)', 'dataphiles' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 30000,
				'step'        => 100,
				'default'     => '',
				'placeholder' => esc_html__( 'Use default', 'dataphiles' ),
				'description' => esc_html__( 'Override the default display duration for this entry. Leave empty to use default.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'text_entries',
			[
				'label'       => esc_html__( 'Text Entries', 'dataphiles' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'content_type' => 'text',
						'impact_text'  => esc_html__( 'Impact', 'dataphiles' ),
						'subline_text' => esc_html__( 'Subline', 'dataphiles' ),
					],
				],
				'title_field' => '<# if ( content_type === "image" ) { #>[Image]<# } else { #>{{{ impact_text }}}<# } #>',
				'max_items'   => 10,
			]
		);

		$this->add_control(
			'impact_html_tag',
			[
				'label'   => esc_html__( 'Impact Text HTML Tag', 'dataphiles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'subline_html_tag',
			[
				'label'   => esc_html__( 'Subline HTML Tag', 'dataphiles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'p',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register animation controls.
	 */
	private function register_animation_controls() {
		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animation', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_enter_animation',
			[
				'label' => esc_html__( 'Enter Animation', 'dataphiles' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'enter_direction',
			[
				'label'       => esc_html__( 'Enter Direction', 'dataphiles' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'down' => esc_html__( 'Drop Down', 'dataphiles' ),
					'up'   => esc_html__( 'Rise Up', 'dataphiles' ),
				],
				'default'     => 'down',
				'description' => esc_html__( 'Direction text enters from.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'impact_enter_duration',
			[
				'label'   => esc_html__( 'Impact Enter Duration (ms)', 'dataphiles' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 50,
				'default' => 600,
			]
		);

		$this->add_control(
			'subline_delay',
			[
				'label'       => esc_html__( 'Subline Delay (ms)', 'dataphiles' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 2000,
				'step'        => 50,
				'default'     => 300,
				'description' => esc_html__( 'Delay after impact text appears before subline fades in.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'subline_enter_duration',
			[
				'label'   => esc_html__( 'Subline Enter Duration (ms)', 'dataphiles' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 50,
				'default' => 500,
			]
		);

		$this->add_control(
			'heading_display',
			[
				'label'     => esc_html__( 'Display', 'dataphiles' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'display_duration',
			[
				'label'       => esc_html__( 'Default Display Duration (ms)', 'dataphiles' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 500,
				'max'         => 10000,
				'step'        => 100,
				'default'     => 3000,
				'description' => esc_html__( 'How long text stays visible before exiting. Can be overridden per entry.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'heading_exit_animation',
			[
				'label'     => esc_html__( 'Exit Animation', 'dataphiles' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'exit_direction',
			[
				'label'       => esc_html__( 'Exit Direction', 'dataphiles' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'down' => esc_html__( 'Drop Down', 'dataphiles' ),
					'up'   => esc_html__( 'Rise Up', 'dataphiles' ),
				],
				'default'     => 'down',
				'description' => esc_html__( 'Direction text exits to.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'impact_exit_duration',
			[
				'label'   => esc_html__( 'Impact Exit Duration (ms)', 'dataphiles' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 50,
				'default' => 500,
			]
		);

		$this->add_control(
			'subline_exit_duration',
			[
				'label'   => esc_html__( 'Subline Exit Duration (ms)', 'dataphiles' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 3000,
				'step'    => 50,
				'default' => 500,
			]
		);

		$this->add_control(
			'heading_cycle',
			[
				'label'     => esc_html__( 'Cycle Settings', 'dataphiles' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'delay_between_entries',
			[
				'label'       => esc_html__( 'Delay Between Entries (ms)', 'dataphiles' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 3000,
				'step'        => 50,
				'default'     => 200,
				'description' => esc_html__( 'Delay after exit animation before next entry appears.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'drop_distance',
			[
				'label'       => esc_html__( 'Drop Distance (px)', 'dataphiles' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 10,
						'max'  => 200,
						'step' => 5,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 50,
				],
				'description' => esc_html__( 'Distance the text moves during animation.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'dataphiles' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'dataphiles' ),
				'label_off'    => esc_html__( 'No', 'dataphiles' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'heading_sparks',
			[
				'label'     => esc_html__( 'Spark Effects', 'dataphiles' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sparks_enabled',
			[
				'label'        => esc_html__( 'Enable Sparks', 'dataphiles' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'dataphiles' ),
				'label_off'    => esc_html__( 'No', 'dataphiles' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => esc_html__( 'Add animated spark particles when impact text appears.', 'dataphiles' ),
			]
		);

		$this->add_control(
			'sparks_count',
			[
				'label'     => esc_html__( 'Sparks Per Side', 'dataphiles' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'default'   => 3,
				'condition' => [
					'sparks_enabled' => 'yes',
				],
			]
		);

		$this->add_control(
			'sparks_color',
			[
				'label'     => esc_html__( 'Spark Color', 'dataphiles' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ff9500',
				'condition' => [
					'sparks_enabled' => 'yes',
				],
			]
		);

		$this->add_control(
			'sparks_size',
			[
				'label'      => esc_html__( 'Spark Size', 'dataphiles' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 2,
						'max'  => 20,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'condition'  => [
					'sparks_enabled' => 'yes',
				],
			]
		);

		$this->add_control(
			'sparks_trail',
			[
				'label'        => esc_html__( 'Show Trail', 'dataphiles' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'dataphiles' ),
				'label_off'    => esc_html__( 'No', 'dataphiles' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'sparks_enabled' => 'yes',
				],
			]
		);

		$this->add_control(
			'sparks_duration',
			[
				'label'       => esc_html__( 'Spark Duration (ms)', 'dataphiles' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 500,
				'max'         => 3000,
				'step'        => 100,
				'default'     => 1000,
				'condition'   => [
					'sparks_enabled' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register style controls.
	 */
	private function register_style_controls() {
		// Impact Text Style.
		$this->start_controls_section(
			'section_impact_style',
			[
				'label' => esc_html__( 'Impact Text', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'impact_alignment',
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
					'{{WRAPPER}} .dataphiles-dynamic-text__impact' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'impact_typography',
				'selector' => '{{WRAPPER}} .dataphiles-dynamic-text__impact',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'impact_color',
			[
				'label'     => esc_html__( 'Color', 'dataphiles' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'impact_margin',
			[
				'label'      => esc_html__( 'Margin', 'dataphiles' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Impact Image Style.
		$this->start_controls_section(
			'section_impact_image_style',
			[
				'label' => esc_html__( 'Impact Image/SVG', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'impact_image_width',
			[
				'label'      => esc_html__( 'Width', 'dataphiles' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact img' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dataphiles-dynamic-text__impact svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'impact_image_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'dataphiles' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact img' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dataphiles-dynamic-text__impact svg' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'impact_image_height',
			[
				'label'      => esc_html__( 'Height', 'dataphiles' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dataphiles-dynamic-text__impact svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'impact_image_object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'dataphiles' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''        => esc_html__( 'Default', 'dataphiles' ),
					'contain' => esc_html__( 'Contain', 'dataphiles' ),
					'cover'   => esc_html__( 'Cover', 'dataphiles' ),
					'fill'    => esc_html__( 'Fill', 'dataphiles' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dataphiles-dynamic-text__impact img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Subline Style.
		$this->start_controls_section(
			'section_subline_style',
			[
				'label' => esc_html__( 'Subline Text', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'subline_alignment',
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
					'{{WRAPPER}} .dataphiles-dynamic-text__subline' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subline_typography',
				'selector' => '{{WRAPPER}} .dataphiles-dynamic-text__subline',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'subline_color',
			[
				'label'     => esc_html__( 'Color', 'dataphiles' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .dataphiles-dynamic-text__subline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subline_margin',
			[
				'label'      => esc_html__( 'Margin', 'dataphiles' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text__subline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Container Style.
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'dataphiles' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_min_height',
			[
				'label'       => esc_html__( 'Minimum Height', 'dataphiles' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', 'vh' ],
				'range'       => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
					'vh' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dataphiles-dynamic-text' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'description' => esc_html__( 'Set a minimum height to prevent layout shifts during animation.', 'dataphiles' ),
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Padding', 'dataphiles' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dataphiles-dynamic-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$entries = $settings['text_entries'];

		if ( empty( $entries ) ) {
			return;
		}

		$impact_tag  = $settings['impact_html_tag'];
		$subline_tag = $settings['subline_html_tag'];

		// Prepare entries data for JavaScript.
		$entries_data = [];
		foreach ( $entries as $entry ) {
			$entry_data = [
				'contentType' => $entry['content_type'],
				'subline'     => esc_html( $entry['subline_text'] ),
			];

			if ( 'image' === $entry['content_type'] && ! empty( $entry['impact_image']['url'] ) ) {
				$entry_data['imageUrl'] = esc_url( $entry['impact_image']['url'] );
				$entry_data['imageAlt'] = ! empty( $entry['impact_image']['alt'] ) ? esc_attr( $entry['impact_image']['alt'] ) : '';
			} else {
				$entry_data['impact'] = esc_html( $entry['impact_text'] );
			}

			// Add custom display duration if set.
			if ( ! empty( $entry['custom_display_duration'] ) ) {
				$entry_data['displayDuration'] = absint( $entry['custom_display_duration'] );
			}

			$entries_data[] = $entry_data;
		}

		// Animation settings.
		$animation_settings = [
			'impactEnterDuration'  => absint( $settings['impact_enter_duration'] ),
			'sublineDelay'         => absint( $settings['subline_delay'] ),
			'sublineEnterDuration' => absint( $settings['subline_enter_duration'] ),
			'displayDuration'      => absint( $settings['display_duration'] ),
			'impactExitDuration'   => absint( $settings['impact_exit_duration'] ),
			'sublineExitDuration'  => absint( $settings['subline_exit_duration'] ),
			'delayBetweenEntries'  => absint( $settings['delay_between_entries'] ),
			'dropDistance'         => absint( $settings['drop_distance']['size'] ),
			'enterDirection'       => $settings['enter_direction'],
			'exitDirection'        => $settings['exit_direction'],
			'pauseOnHover'         => 'yes' === $settings['pause_on_hover'],
			'sparksEnabled'        => 'yes' === $settings['sparks_enabled'],
			'sparksCount'          => absint( $settings['sparks_count'] ),
			'sparksColor'          => $settings['sparks_color'],
			'sparksSize'           => absint( $settings['sparks_size']['size'] ),
			'sparksTrail'          => 'yes' === $settings['sparks_trail'],
			'sparksDuration'       => absint( $settings['sparks_duration'] ),
			'entries'              => $entries_data,
		];

		$widget_id = $this->get_id();

		// Get first entry for initial render.
		$first_entry = $entries[0];

		?>
		<div class="dataphiles-dynamic-text"
			 id="dataphiles-dynamic-text-<?php echo esc_attr( $widget_id ); ?>"
			 data-settings="<?php echo esc_attr( wp_json_encode( $animation_settings ) ); ?>">

			<div class="dataphiles-dynamic-text__entry">
				<div class="dataphiles-dynamic-text__impact-wrapper">
					<div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--left"></div>
					<<?php echo esc_html( $impact_tag ); ?> class="dataphiles-dynamic-text__impact">
						<?php if ( 'image' === $first_entry['content_type'] && ! empty( $first_entry['impact_image']['url'] ) ) : ?>
							<img src="<?php echo esc_url( $first_entry['impact_image']['url'] ); ?>" alt="<?php echo esc_attr( $first_entry['impact_image']['alt'] ?? '' ); ?>" />
						<?php else : ?>
							<?php echo esc_html( $first_entry['impact_text'] ); ?>
						<?php endif; ?>
					</<?php echo esc_html( $impact_tag ); ?>>
					<div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--right"></div>
				</div>

				<<?php echo esc_html( $subline_tag ); ?> class="dataphiles-dynamic-text__subline">
					<?php echo esc_html( $first_entry['subline_text'] ); ?>
				</<?php echo esc_html( $subline_tag ); ?>>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		var entries = settings.text_entries;
		if ( ! entries || ! entries.length ) {
			return;
		}

		var impactTag = settings.impact_html_tag || 'h2';
		var sublineTag = settings.subline_html_tag || 'p';
		var firstEntry = entries[0];
		var impactText = firstEntry.impact_text || 'Impact';
		var sublineText = firstEntry.subline_text || 'Subline';
		var isImage = firstEntry.content_type === 'image' && firstEntry.impact_image && firstEntry.impact_image.url;
		#>
		<div class="dataphiles-dynamic-text">
			<div class="dataphiles-dynamic-text__entry dataphiles-dynamic-text__entry--editor">
				<div class="dataphiles-dynamic-text__impact-wrapper">
					<div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--left"></div>
					<{{{ impactTag }}} class="dataphiles-dynamic-text__impact dataphiles-dynamic-text__impact--visible">
						<# if ( isImage ) { #>
							<img src="{{{ firstEntry.impact_image.url }}}" alt="{{{ firstEntry.impact_image.alt || '' }}}" />
						<# } else { #>
							{{{ impactText }}}
						<# } #>
					</{{{ impactTag }}}>
					<div class="dataphiles-dynamic-text__sparks dataphiles-dynamic-text__sparks--right"></div>
				</div>

				<{{{ sublineTag }}} class="dataphiles-dynamic-text__subline dataphiles-dynamic-text__subline--visible">
					{{{ sublineText }}}
				</{{{ sublineTag }}}>
			</div>

			<# if ( entries.length > 1 ) { #>
			<div class="dataphiles-dynamic-text__preview-note">
				<?php echo esc_html__( 'Cycling through', 'dataphiles' ); ?> {{{ entries.length }}} <?php echo esc_html__( 'entries on frontend', 'dataphiles' ); ?>
			</div>
			<# } #>
		</div>
		<?php
	}
}
