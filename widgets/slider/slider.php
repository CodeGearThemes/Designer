<?php

namespace Designer\Widgets\Slider;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Slider extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_script( 'slider', \Designer::plugin_url().'widgets/slider/assets/slider.js', array('swiper','elementor-frontend'), '1.0.0', true );

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
		return 'slider';
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
		return esc_html__( 'Slider', 'designer' );
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
		return 'eicon-slides';
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
		return 'mailto: info@codegearthemes.com';
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
		return [ 'slider', 'image', 'gallery', 'carousel' ];
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
        return [ 'slider' ];
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
				'label' => __( 'Slides', 'designer' ),
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
				]
			]
		);

        $repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);

        $repeater->add_control(
			'caption_header',
			[
				'label' => esc_html__( 'Slider caption', 'designer' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $repeater->add_control(
			'label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Label', 'designer' ),
				'placeholder' => __( 'Type title label here', 'designer' ),
			]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
			]
		);

        $repeater->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div'
				],
				'default' => 'h2',
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Subtitle', 'designer' ),
				'placeholder' => __( 'Type subtitle here', 'designer' ),
			]
		);

        $repeater->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'designer' ),
				'placeholder' => __( 'Shop Now', 'designer' )
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
			]
		);
        $repeater->add_control(
            'video_link',
            [
                'label'=>__('Video Link','designer'),
                'type' => Controls_Manager::URL,
                'label_block'=>true,
                'placeholder' => 'Link from Media only',
            ]
        );

        $repeater->add_control(
			'button_arrow_icon',
			[
				'label' => __( 'Link icon', 'designer' ),
				'type' => Controls_Manager::ICONS,
                'separator' => 'after'
			]
		);

        $repeater->add_responsive_control(
            'caption_alignment',
            [
                'label' => __( 'Horizontal Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'text-center',
                'options' => [
                    'text-left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'text-center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'text-right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
            ]
        );

        $repeater->add_responsive_control(
            'caption_vertical_aligment',
            [
                'label' => __( 'Vertical Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'flex-center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Top', 'designer' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'flex-center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __( 'Bottom', 'designer' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => true,
            ]
        );
            $this->add_control(
                'slides',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '<# print(title || "Slide Item"); #>',
                    'default' => array_fill( 0, 2, [
                        'image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ])
                ]
            );
        

        $this->end_controls_section();
        $this->register_slider_controls();
	}

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_slider_controls() {
        $this->__slider_settings_controls();
        $this->__slider_item_style_controls();
        $this->__slider_content_style_controls();
        $this->__slider_arrow_style_controls();
        $this->__slider_dot_style_controls();
    }

    protected function __slider_settings_controls(){
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
			'autoplay_speed',
			[
				'label' => esc_html__( 'Speed (ms)', 'designer' ),
				'type' =>  Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 15000,
				'step' => 100,
				'default' => 1000,
				'condition' => [
					'autoplay' => 'yes',
				]
			]
		);
        $this->add_control(
			'autoplay_hover_pause',
			[
				'label' => esc_html__( 'Pause on hover', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'designer' ),
				'label_off' => esc_html__( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				]
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
				'separator' => 'before',
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

        $this->add_control(
            'video_play',
            [
                'label' => __('Video Play','designer'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' =>__('Yes','designer'),
                'label_off' =>__('No','designer'),
                'default' =>'no',
                'frontend_available' =>true
            ]
            );

		$this->end_controls_section();
    }

    protected function __slider_item_style_controls() {

        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'Slider', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'image_render',
			[
				'label' => esc_html__( 'Image render', 'designer' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__( 'Normal', 'designer' ),
					'background' => esc_html__( 'Background', 'designer' )
				],
			]
		);

        $this->add_responsive_control(
            'slider_height',
            [
                'label' => __( 'Slider height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', 'rem'],
                'default'   => [
                    'size' => 75,
                    'unit' => 'vh'
                ],
                'selectors' => [
                    '{{WRAPPER}} .block--image-slider .slider-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_render' => 'background',
                ]
            ]
        );

        $this->add_responsive_control(
            'slider_border_radius',
            [
                'label' => __( 'Border radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'selector' => '{{WRAPPER}} .block--image-slider',
            ]
        );

        $this->end_controls_section();
    }

    protected function __slider_content_style_controls() {

        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Caption', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_label',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Label', 'designer' ),
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label',
                'selector' => '{{WRAPPER}} .label',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label' => __( 'Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'designer' ),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Subtitle', 'designer' ),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __( 'Text Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle',
                'selector' => '{{WRAPPER}} .subtitle',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'subtitle_spacing',
            [
                'label' => __( 'Bottom Spacing', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 45,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        /*----- Button Start ------*/
        $this->add_control(
            '_heading_link',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Link Style', 'designer' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label' => __( 'Button height', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default' => [
                    'size' => 45,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-caption-item a' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typo',
                'selector' => '{{WRAPPER}} .slider-caption-item a',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
            '_tab_button_normal',
            [
                'label' => __( 'Normal', 'designer' ),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .slider-caption-item .button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __( 'Background color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slider-caption-item .button' => 'background-color: {{VALUE}};border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

		$this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => __( 'Hover', 'designer' ),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Button hover color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .slider-caption-item .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __( 'Button hover background', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slider-caption-item .button:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        /*----- Button End ------*/

        $this->add_control(
            '_heading_caption',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Style', 'designer' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
			'caption_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'designer' ),
				'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => 30,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .slider-inner .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'slider_caption_radius',
            [
                'label' => __( 'Caption border radius', 'designer' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'selector' => '{{WRAPPER}} .swiper-slide .content',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function __slider_arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Arrow', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_position_toggle',
            [
                'label' => __( 'Position', 'designer' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'designer' ),
                'label_on' => __( 'Custom', 'designer' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'arrow' => 'yes',
                ]
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
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
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
                'default'   => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'top: {{SIZE}}{{UNIT}};-webkit-transform: translateY(-{{SIZE}}{{UNIT}}); transform: translateY(-{{SIZE}}{{UNIT}});',
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
                    'arrow_position_toggle' => 'yes',
                    'arrow' => 'yes',
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
                'default'   => [
                    'size' => 30,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_responsive_control(
            'arrow_size',
            [
                'label' => __( 'Size', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'   => [
                    'size' => 60,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slide-previous svg, {{WRAPPER}} .slide-next svg' => 'width: calc( {{SIZE}}{{UNIT}} / 2 );height: calc( {{SIZE}}{{UNIT}} / 2 );'
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next',
                'condition' => [
                    'arrow' => 'yes',
                ]
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
                'condition' => [
                    'arrow' => 'yes',
                ]
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
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_background_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous, {{WRAPPER}} .slide-next' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
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
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_background_color',
            [
                'label' => __( 'Background Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Hover Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#115CFA',
                'selectors' => [
                    '{{WRAPPER}} .slide-previous:hover, {{WRAPPER}} .slide-next:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'arrow' => 'yes',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function __slider_dot_style_controls() {

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

		if ( empty( $settings['slides'] ) ) {
			return;
		}

        $config = [
			'dots'				=> !empty($settings['dots']),
            'arrows'			=> !empty($settings['arrow']),
			'autoplay'			=> !empty($settings['autoplay']),
            'pauseOnHover'		=> !empty($settings['autoplay_hover_pause']),
            'speed'				=> !empty($settings['speed']) ? $settings['speed'] : 1000,
            'loop'  			=> ( !empty($settings['loop'] ) && $settings['loop'] == 'yes' ) ? true : false,
			'pagination' => [
				'el' => '.swiper-pagination-'.$this->get_id(),
				'type' => "bullets",
                'clickable' => true,
			],
			'navigation' => [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
			],
			'scrollbar' => [
				'el' => '.swiper-scrollbar-'.$this->get_id(),
			]
        ];

        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--image-slider' ],
				'data-selector' => $this->get_id(),
                'data-config' => wp_json_encode($config)
            ]
        );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> >
            <div id="block_slider_<?php echo esc_attr( $this->get_id() ) ?>" class="swiper">
                <div class="slider-inner slider-wrapper swiper-wrapper">
                    <?php
                        foreach ( $settings['slides'] as $slide ) : ?>
                            <?php
                                $this->add_render_attribute( 'image', 'src', $slide['image']['url'] );
                                $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $slide['image'] ) );
                                $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $slide['image'] ) );
                                $this->add_render_attribute( 'image', 'class', 'image' );
                            ?>

                            <div class="swiper-slide slider-slide">
                                <div class="slider-image <?php echo esc_attr( $settings['image_render'] ); ?>">
                                <?php if((isset($slide['video_link']['url']) && !empty($slide['video_link']['url'])) && $settings['video_play']=='yes'){ ?>
                                    <video autoplay muted loop>
                                        <source src="<?php echo $slide['video_link']['url'];?>" ></source>
                                    </video>
                                <?php }else{
                                    echo(\Elementor\Group_Control_Image_Size::get_attachment_image_html( $slide, 'thumbnail', 'image' )); 
                                }?>        
                                </div>
                                <?php if ( !empty($slide['title']) || !empty($slide['subtitle']) ) : ?>
                                    <?php $classes = [ $slide['caption_alignment'], $slide['caption_vertical_aligment'] ]; ?>
                                    <div class="slider-caption-item">
                                        <div class="container inner-block">
                                            <div class="content <?php echo implode(' ', $classes ); ?>">
                                                <?php if ( $slide['label'] ) : ?>
                                                    <small class="label"><?php echo wp_kses_post( $slide['label'] ); ?></small>
                                                <?php endif; ?>
                                                <?php
                                                    if ( $slide['title'] ) {
                                                        printf( '<%1$s class="title h1">%2$s</%1$s>',
                                                            tag_escape( $slide['title_tag'], 'h2' ),
                                                            wp_kses_post( $slide['title'] )
                                                        );
                                                    }
                                                ?>
                                                <?php if ( $slide['subtitle'] ) : ?>
                                                    <p class="subtitle"><?php echo wp_kses_post( $slide['subtitle'] ); ?></p>
                                                <?php endif; ?>
                                                <?php
                                                    if( isset( $slide['link'] ) && ! empty( $slide['link']['url'] ) ) { ?>
                                                        <a class="btn button" href="<?php echo esc_url( $slide['link']['url'] ); ?>" title="<?php echo esc_attr( $slide['title'] ); ?>">
                                                            <?php echo esc_html($slide['button_label']) ?>
                                                            <?php \Elementor\Icons_Manager::render_icon( $slide['button_arrow_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                                        </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        <?php
                        endforeach;
                    ?>
                </div>
                <?php if( $settings['arrow'] == 'yes' ): ?>
                    <div class="slide-previous swiper-button-prev-<?php echo esc_attr($this->get_id()) ?>">
                        <?php
                            if( $settings['arrow_icon']['value'] ){
                                \Elementor\Icons_Manager::render_icon( $settings['arrow_icon'], [ 'aria-hidden' => 'true' ] );
                            }else{ ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                    <path d="M9 15.3902L20.5144 26.211L21 25.7254L11.4277 15.3208L21 4.98555L20.5145 4.5L9 15.3902Z" fill="currentColor"></path>
                                </svg>
                        <?php } ?>
                    </div>
                    <div class="slide-next swiper-button-next-<?php echo esc_attr($this->get_id()) ?>">
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
        </div>
        <?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 *
	 * @access protected
	 */
    protected function content_template() {}

}