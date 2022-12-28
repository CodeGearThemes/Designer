<?php

namespace Designer\Widgets\Scroll_Down;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Scroll_Down extends Widget_Base{

    /**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'scroll';
	}

    /**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Scroll Down', 'designer' );
	}

    /**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slider-vertical';
	}

    /**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'mailto: support@codegearthemes.com';
	}

    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'designer' ];
	}


    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [
			'widget',
			'scroll',
            'CodegearThemes',
		];
	}

    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_controls(){

        $this->start_controls_section(
            '_general_settings',
            [
                'label' => esc_html__('Settings', 'designer'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Scroll icon', 'designer' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-down',
                    'library' => 'fa-regular',
                ],
            ]
        );

        $this->add_control(
			'section',
			[
				'label' => __( 'Section Selector', 'designer' ),
                'description' =>  __( 'Please enter section selector, CSS selector ID of section', 'designer' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'section-slider', 'designer' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->end_controls_section();

        $this->register_style_controls();
    }

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_style_controls() {
		$this->__general_style_controls();
    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Style', 'designer'),
            ]
        );

        $this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
                    'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .block-scroll-btn .scroll-down' => 'width: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__( 'Height', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
                    'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .block-scroll-btn .scroll-down' => 'height: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'designer' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
                    'em' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .block-scroll-btn .scroll-down' => 'font-size: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_control(
			'icon_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block-scroll-btn .scroll-down',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-scroll-btn .scroll-down' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#377ef9',
                'selectors' => [
                    '{{WRAPPER}} .block-scroll-btn .scroll-down' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display(); ?>

        <div class="block-scroll-btn">
            <a class="scroll-down" href="#<?= $settings['section']; ?>">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'false' ] ); ?>
            </a>
        </div>

        <?php
    }

}
