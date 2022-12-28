<?php

namespace Designer\Widgets\Testimonial_Slider;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_Slider extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_script( 'testimonial', \Designer::plugin_url().'widgets/testimonial-slider/assets/testimonial.js', array('swiper','elementor-frontend'), '1.0.0', true );

    }

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
		return 'testimonial-slider';
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
		return esc_html__( 'Testimonial Slider', 'designer' );
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
		return 'eicon-testimonial-carousel';
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
		return 'https://developers.elementor.com/docs/widgets/';
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
		return [ 'testimonial', 'testimonial slider', 'reviews' ];
	}

    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'swiper' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'testimonial' ];
    }

    /**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
        $this->start_controls_section(
			'_general_settings',
			[
				'label' => __( 'General', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
                'label' => __( 'Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'content',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Content', 'designer' ),
				'placeholder' => __( 'Type content here', 'designer' ),
			]
		);

        $repeater->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Name', 'designer' ),
				'placeholder' => __( 'Type name here', 'designer' ),
                'separator' => 'before',
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'position',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Postion', 'designer' ),
				'placeholder' => __( 'Type position here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'testimonials',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Testimonial"); #>',
                'default' => array_fill( 0, 2, [
                    'image' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ])
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'medium',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'designer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'designer' ),
				'type' =>  Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

        $this->add_control(
			'arrow',
			[
				'label' => esc_html__( 'Show arrow', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrow_icon',
			[
				'label' => esc_html__( 'Arrow Icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'arrow' => 'yes',
				]
			]
		);

        $this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Show dots', 'designer' ),
				'type' =>   Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Infinite Loop?', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'designer' ),
				'label_off' => __( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
        );

        $this->add_responsive_control(
			'slide_perpage',
			[
				'label' => esc_html__( 'Slides per page', 'designer' ),
				'type' =>  Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 6,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
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
        $this->__testimonial_general_style_controls();
        $this->__testimonial_content_style_controls();
        $this->__testimonial_meta_controls();
        $this->__testimonial_arrow_style_controls();
        $this->__testimonial_dot_style_controls();
    }

    protected function __testimonial_general_style_controls() {

        $this->start_controls_section(
            '_section_general_style_item',
            [
                'label' => __( 'General', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'testimonial_general_bg',
                'label'    => __( 'Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block-testimonial-slider',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'testimonial_general_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block-testimonial-slider',
            ]
        );

        $this->add_responsive_control(
            'item_horizontal_spacing',
            [
                'label' => __( 'Horizontal Spacing', 'designer' ),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => '15',
				'min' => 0,
				'max' => 100,
				'step' => 5,
				'default' => 15,
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function __testimonial_content_style_controls() {

        $this->start_controls_section(
            '_section_content_style_item',
            [
                'label' => __( 'Content', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'testimonial_content_bg',
                'label'    => __( 'Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item',
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label'      => __( 'Padding', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'testimonial_content_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'title-text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item .title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'content_heading',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'content-text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Content color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .content' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item .content',
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .content' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );
       

        $this->end_controls_section();
    }

    protected function __testimonial_meta_controls() {

        $this->start_controls_section(
            '_section_meta_style_item',
            [
                'label' => __( 'Meta', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta-text-align',
            [
                'label'     => __( 'Alignment', 'designer' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'image_size',
            [
                'label'      => __( 'Size', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 75,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 16,
                        'max' => 300,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}  .testimonial-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_spacing',
            [
                'label'      => __( 'Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .testimonial-image' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'testimonial_image_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}}  .testimonial-image img',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'author_heading',
			[
				'label' => esc_html__( 'Name', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'author_color',
            [
                'label' => __( 'Name color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta .name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'author_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta .name',
            ]
        );

        $this->add_responsive_control(
            'name_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta .name' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'position_heading',
			[
				'label' => esc_html__( 'Position', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'position_color',
            [
                'label' => __( 'Position color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta .position' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'position_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-testimonial-slider .content-item .author-meta .position',
            ]
        );






        $this->end_controls_section();
    }

    protected function __testimonial_arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation : Arrow', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrow' => 'yes',
                ]
            ],
            
        );

        $this->add_control(
            'arrow_position_toggle',
            [
                'label' => __( 'Position', 'designer' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'designer' ),
                'label_on' => __( 'Custom', 'designer' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'arrow_position_y',
            [
                'label' => __( 'Vertical', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 50,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-next, {{WRAPPER}} .slide-previous' => 'top: {{SIZE}}{{UNIT}}; transform: translateY({{SIZE}}{{UNIT}}); -webkit-transform: translateY(-{{SIZE}}{{UNIT}})',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_position_x',
            [
                'label' => __( 'Horizontal', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -110,
                        'max' => 110,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 0,
					'unit' => '%',
				],
				'tablet_default' => [
					'size' => 0,
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 0,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_responsive_control(
            'button_size',
            [
                'label' => __( 'Button size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 40
				]
            ]
        );

        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Arrow size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
					'unit' => 'px',
					'size' => 30
				],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next',
            ]
        );

        $this->add_responsive_control(
            'arrow_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_arrow' );

        $this->start_controls_tab(
            '_tab_arrow_normal',
            [
                'label' => __( 'Normal', 'designer' ),
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_arrow_hover',
            [
                'label' => __( 'Hover', 'designer' ),
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function __testimonial_dot_style_controls() {

        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Dots', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'rem' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 150,
                    ],
                ],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_nav_align',
            [
                'label' => __( 'Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'justify-content: {{VALUE}}'
                ],
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'dots_nav_size',
            [
                'label' => __( 'Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'dots_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .swiper-pagination span',
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius',
            [
                'label' => __( 'Border Radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
                'condition' => [
                    'dots' => 'yes',
                ]
            ]
        );

        $this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#115CFA',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'dots' => 'yes',
				]
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots active background', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
				],
				'condition' => [
					'dots' => 'yes',
				],
				'separator' => 'after',
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
        $settings = $this->get_settings_for_display();
		if ( empty( $settings['testimonials'] ) ) {
			return;
        }

        $config = [
            'arrows'			=> !empty($settings['arrow']),
			'autoplay'			=> !empty($settings['autoplay']),
            'loop'  			=> ( !empty($settings['loop'] ) && $settings['loop'] == 'yes' ) ? true : false,
			'navigation' => [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
            ],
            'pagination' => [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => "bullets",
                'clickable' => true,
			],
            'breakpoints'		=> [
                320 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_mobile']['size']) ? $settings['slide_perpage_mobile']['size'] : 1,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_mobile']['size']) ? $settings['slides_scroll_mobile']['size'] : 1,
                ],
                768 => [
                    'slidesPerView'    => !empty($settings['slide_perpage_tablet']['size']) ? $settings['slide_perpage_tablet']['size'] : 3,
                    'slidesPerGroup'   => !empty($settings['slides_scroll_tablet']['size']) ? $settings['slides_scroll_tablet']['size'] : 1
                ],
                1024 => [
                    'slidesPerView'    => !empty($settings['slide_perpage']['size']) ? $settings['slide_perpage']['size'] : 3,
                    'slidesPerGroup'   => !empty($settings['slides_scroll']['size']) ? $settings['slides_scroll']['size'] : 1,
                ]
            ]
        ];

        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block-testimonial-slider' ],
				'data-selector' => $this->get_id(),
                'data-config' => wp_json_encode($config)
            ]
        );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div id="testimonial_slider_<?php echo esc_attr( $this->get_id() ) ?>" class="swiper">
                <div class="testimonial-inner testimonial-wrapper swiper-wrapper">

                    <?php
                        foreach ( $settings['testimonials'] as $testimonial ) : ?>
                            <div class="swiper-slide testimonial-slide">
                                <?php
                                    $this->add_render_attribute( 'image', 'src', $testimonial['image']['url'] );
                                    $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $testimonial['image'] ) );
                                    $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $testimonial['image'] ) );
                                    $this->add_render_attribute( 'image', 'class', 'image' );
                                ?>
                                <?php if( $testimonial['title'] || $testimonial['content'] ): ?>
                                    <div class="content-item">
                                        <?php if( $testimonial['title']): ?>
                                            <h5 class="title"><?php echo wp_kses_post( $testimonial['title'] ); ?></h5>
                                        <?php endif; ?>
                                        <?php if( $testimonial['content']): ?>
                                            <p class="content"><?php echo wp_kses_post( $testimonial['content'] ); ?></p>
                                        <?php endif; ?>

                                        <?php if( $testimonial['name']): ?>
                                            <div class="author-meta">
                                                <div class="testimonial-image">
                                                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'thumbnail', 'image' ); ?>
                                                </div>
                                                <h4 class="name"><?php echo wp_kses_post( $testimonial['name'] ); ?></h4>
                                                <small class="position"><?php echo wp_kses_post( $testimonial['position'] ); ?></small>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php
                        endforeach;
                    ?>

                </div>

            </div>
            <?php if( $settings['arrow'] == 'yes' ): ?>
                <div class="slide-previous swiper-button-prev-<?php echo esc_attr( $this->get_id() ) ?>">
                    <?php
                        if( $settings['arrow_icon']['value'] ){
                            \Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
                        }else{ ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
                            </svg>
                    <?php } ?>
                </div>
                <div class="slide-next swiper-button-next-<?php echo esc_attr( $this->get_id() ) ?>">
                    <?php
                        if( $settings['arrow_icon']['value'] ){
                            \Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
                        }else{ ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
                            </svg>
                    <?php } ?>
                </div>
            <?php endif; ?>
            <?php if( $settings['dots'] == 'yes' ): ?>
                <div class="swiper-pagination swiper-pagination-<?php echo esc_attr($this->get_id()) ?>"></div>
            <?php endif; ?>
        </div>
        <?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 *
	 * @access protected
	 */
    protected function content_template() { }

}
