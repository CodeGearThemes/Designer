<?php

namespace Designer\Widgets\Service;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Service extends Widget_Base{

    public function __construct($data =[], $args = null){
        parent::__construct($data, $args);

        if( !wp_script_is('swiper', 'registered') ){
            wp_register_script( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/js/swiper-bundle.min.js', ['elementor-frontend'], '7.0.1', true );
        }
        wp_register_script( 'service-slider', \Designer::plugin_url().'widgets/service/assets/service.js', ['swiper'], '1.0.0', true );
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
		return 'service';
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
		return esc_html__( 'service', 'designer' );
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
		return 'eicon-elementor';
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
		return [ 'service', 'slider' ];
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
        return [ 'service-slider' ];
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
				'label' => __( 'Service', 'designer' ),
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
			'link',
			[
				'label' => __( 'Link', 'designer' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
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

        $this->add_control(
			'service',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "image"); #>',
                'default' => array_fill( 0, 3, [
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
				'default' => 'full',
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
						'min' => 2,
						'max' => 6,
						'step' => 2,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 6,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'default' => [
					'size' => 6,
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
        $this->__client_item_style_controls();
        $this->__client_arrow_style_controls();
    }

    protected function __client_item_style_controls() {

        $this->start_controls_section(
            '_section_style_item',
            [
                'label' => __( 'Service item', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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

    protected function __client_arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation : Arrow', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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

    /**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render(){
        $settings = $this->get_settings_for_display();
        if ( empty( $settings['service'] ) ) {
			return;
        }

        $config = [
            'arrows'			=> !empty($settings['arrow']),
			'autoplay'			=> !empty($settings['autoplay']),
            'loop'  			=> ( !empty($settings['loop'] ) && $settings['loop'] == 'yes' ) ? true : false,
			'centeredSlides'    => true,
            'slidesPerView' => 2,
            'spaceBetween' =>30,
            'pagination' => [
                'el'=>'.swiper-pagination',
                'clickable'=> true,
            ],
            'navigation' => [
				'nextEl' => '.swiper-button-next-'.$this->get_id(),
				'prevEl' => '.swiper-button-prev-'.$this->get_id(),
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
                'class' => [ 'block--service-slider' ],
				'data-selector' => $this->get_id(),
                'data-config' => wp_json_encode($config)
            ]
        );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div id="service_slider_<?php echo esc_attr( $this->get_id() ) ?>" class="swiper">
                <div class="service-inner service-wrapper swiper-wrapper">

                    <?php
                        foreach ( $settings['service'] as $service ) :?>
                            <div class="swiper-slide client-slide">
                                <?php if( isset( $service['link'] ) && ! empty( $service['link']['url'] ) ): ?>
                                    <a href="<?php echo esc_url( $service['link']['url'] ); ?>" title="<?php echo esc_attr( $service['title'] ); ?>">
                                <?php endif; ?>
                                    <?php
                                        $this->add_render_attribute( 'image', 'src', $service['image']['url'] );
                                        $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $service['image'] ) );
                                        $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $service['image'] ) );
                                        $this->add_render_attribute( 'image', 'class', 'image' );
                                    ?>
                                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $service, 'thumbnail', 'image' ); ?>
                                <?php if( isset( $service['link'] ) && ! empty( $service['link']['url'] ) ): ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php
                        endforeach;
                    ?>

                </div>
                <div class="swiper-pagination"></div>
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
        </div>
        <?php

    }
}

