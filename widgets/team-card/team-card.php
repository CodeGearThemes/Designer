<?php

namespace Designer\Widgets\Team_Card;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Team_Card extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'team-cards', \Designer::plugin_url().'widgets/team-card/assets/team.css', array(), '1.0.0', 'all' );
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
		return 'team-card';
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
		return esc_html__( 'Team', 'designer' );
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
		return 'eicon-image-box';
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
		return [ 
			'widget',
			'team',
			'member'
		];
	}

	/**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'team-cards' ];
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
			'image_text_settings',
			[
				'label' => __( 'Team', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 
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
		

		$this->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Name', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'position',
			[
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label' => __( 'Position', 'designer' ),
				'placeholder' => __( 'Type position here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'social',
            [
                'label' => __( 'Social', 'startupx-toolkit' ),
                'label_block' => true,
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-twitter',
                    'library' => 'fa-brands',
                ],
            ]
		);

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'startupx-toolkit' ),
				'default' => __( 'Twitter', 'startupx-toolkit' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater->add_control(
			'link',
			[
				'label' => __( 'Socail Profile Link', 'startupx-toolkit' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://twitter.com',
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $this->add_control(
			'profiles',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Social Profile"); #>',
                'default' => array_fill( 0, 1, [
                    'default' => [
                        'value' => 'fab fa-twitter',
                        'library' => 'fa-brands',
                    ]
                ])
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
		$this->__layout_style_controls();
        $this->__content_style_controls();
    }

	protected function __layout_style_controls() {
    
        $this->start_controls_section(
            '_section_style_layout',
            [
                'label' => __( 'Layout', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'layout',
			[
				'label'     => __( 'Layout', 'designer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'layout-1'        => __( 'Layout 1', 'designer' ),
					'layout-2'        => __( 'Layout 2', 'designer' ),
                    'layout-3'        => __( 'Layout 3', 'designer' ),
					'layout-4'        => __( 'Layout 4', 'designer' ),
                    'layout-5'        => __( 'Layout 5', 'designer' ),
					'layout-6'        => __( 'Layout 6', 'designer' ),
				],
				'default'   => 'vertical',
			]
		);

        $this->end_controls_section();
    }

	protected function __content_style_controls() {
    
        $this->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Information', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'name_color',
            [
                'label' => __( 'Name Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--team-card .name' => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name',
                'selector' => '{{WRAPPER}} .block--team-card .name',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
			'positionhr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
            'position_color',
            [
                'label' => __( 'Position Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--team-card .position' => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position',
                'selector' => '{{WRAPPER}} .block--team-card .position',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
			'socialhr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width/Height', 'startupx-toolkit' ),
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
					'{{WRAPPER}} .block--team-card .social-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				]
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'startupx-toolkit' ),
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
					'{{WRAPPER}} .block--team-card .social-item .icon-link' => 'font-size: {{SIZE}}{{UNIT}}',
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
				'label' => esc_html__( 'Border', 'startupx-toolkit' ),
				'selector' => '{{WRAPPER}} .block--team-card .social-item',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'startupx-toolkit' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}  .block--team-card .social-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'color_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->start_controls_tabs( '_tabs_arrow' );
    
        $this->start_controls_tab(
            '_tab_social_normal',
            [
                'label' => __( 'Normal', 'startupx-toolkit' ),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => __( 'Background color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#377ef9',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
    
        $this->start_controls_tab(
            '_tab_social_hover',
            [
                'label' => __( 'Hover', 'startupx-toolkit' ),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => __( 'Color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background',
            [
                'label' => __( 'Background color', 'startupx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'default'=> '#377ef9',
                'selectors' => [
                    '{{WRAPPER}}  .block--team-card .social-item:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
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
	protected function render() {

		$settings = $this->get_settings_for_display();
		require \Designer::plugin_dir().'widgets/team-card/snippets/'.$settings['layout'].'.php';
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function content_template() {}

}