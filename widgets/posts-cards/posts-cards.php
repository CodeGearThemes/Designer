<?php

namespace Designer\Widgets\Posts_Cards;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Designer\Core\Helper;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

class Posts_Cards extends Widget_Base{

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
		return 'posts-cards';
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
		return esc_html__( 'Advanced Posts', 'designer' );
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
		return 'eicon-archive-posts';
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
			'posts'
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
                'label' => esc_html__('Layout', 'editorx-toolkit'),
            ]
        );

		$this->add_control(
            'layout',
            [
                'label' => esc_html__('Select Layout', 'editorx-toolkit'),
                'type' => 'image-select',
                'default' => 'layout-1',
                'options' => [
                    'layout-1' => [
                        'title' => esc_html__('Default', 'editorx-toolkit'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block1.png',
                        'width' => '50%',
                    ],
                    'layout-2' => [
                        'title' => esc_html__('Layout 2', 'editorx-toolkit'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block2.png',
                        'width' => '50%',
                    ],
                    'layout-3' => [
                        'title' => esc_html__('Layout 3', 'editorx-toolkit'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block3.png',
                        'width' => '50%',
                    ],
					'layout-4' => [
                        'title' => esc_html__('Layout 4', 'editorx-toolkit'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block4.png',
                        'width' => '50%',
                    ],
					'layout-5' => [
                        'title' => esc_html__('Layout 5', 'editorx-toolkit'),
                        'imagesmall' => \Designer::plugin_url() .'assets/src/post-block/block5.png',
                        'width' => '50%',
                    ]
                ],
            ]
        );

		$this->add_control(
			'column',
			[
				'label' => esc_html__( 'Column', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 6,
				'step' => 1,
				'default' => 4,
				'condition' => [
                    'layout' => array('layout-4'),
                ],
			]
		);

		$this->add_control(
			'gutter',
			[
				'label' => esc_html__( 'Remove gutter', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Off', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'separator' => 'after',
				'default' => 'no',
				'condition' => [
                    'layout' => array('layout-4'),
                ],
			]
		);

		$this->add_responsive_control(
            'image_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'editorx-toolkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0.01,
                        'max' => 3.0,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0.5
                ],
                'tablet_default' => [
                    'unit' => '%',
                    'size' => 0.3
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => 0.5
                ],
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .omega-block article .image-left' => 'padding-bottom: calc( {{size}} * 100% );',
                ],
                'description' => esc_html__("Not applicable for Featured Layouts.", "editorx-toolkit"),
            ]
        );

        $this->end_controls_section();
        $this->register_advanced_controls(); 
    }

    /**
	 * Register style controls.
	 *
	 * Add input fields to allow the user to customize the widget style.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function register_advanced_controls() {
		$this->__general_query_controls();
		$this->__featured_style_controls();
		$this->__default_style_controls();
		$this->__general_style_controls();
    }

	protected function __general_query_controls() {

		$this->start_controls_section(
            '_query_settings',
            [
                'label' => esc_html__('Query', 'editorx-toolkit'),
            ]
        );

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Select Category', 'editorx-toolkit' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => Helper::instance()->categories(),
			]
		);

		$this->add_control(
			'post_per_page',
			[
				'label' => esc_html__( 'Post per page', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'author',
			[
				'label' => esc_html__( 'Show Author', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Hide', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => esc_html__( 'Show Date', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Hide', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cat',
			[
				'label' => esc_html__( 'Show Categories', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Hide', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();
	}

	protected function __featured_style_controls() {
    
        $this->start_controls_section(
            '_section_style_featured',
            [
                'label' => __( 'First Block', 'editorx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'layout!' => array('layout-4'),
                ],
            ]
        );

		$this->add_control(
			'alpha_style',
			[
				'label' => esc_html__( 'Style', 'editorx-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'thumb-background',
				'options' => [
					'default'  	 => esc_html__( 'Default Style', 'editorx-toolkit' ),
					'thumb-left' => esc_html__( 'Thumb Left', 'editorx-toolkit' ),
					'thumb-right' => esc_html__( 'Thumb Right', 'editorx-toolkit' ),
					'thumb-background'  => esc_html__( 'Thumb Background', 'editorx-toolkit' ),
				],
			]
		);

		$this->add_control(
			'featured_image',
			[
				'label' => esc_html__( 'Show featured image', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Hide', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'separator' => 'after',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'category_style',
			[
				'label' => esc_html__( 'Category style', 'editorx-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  	 => esc_html__( 'Default', 'editorx-toolkit' ),
					'color'  	 => esc_html__( 'Style 1', 'editorx-toolkit' ),
					'background' => esc_html__( 'Style 2', 'editorx-toolkit' ),
				],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .alpha-block .categories a',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
		);

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'editorx-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .alpha-block .entry-title a' => 'color: {{VALUE}}',
                ],
				'separator' => 'before',
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .alpha-block .entry-title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
            'meta_color',
            [
                'label' => __( 'Meta Color', 'editorx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .alpha-block .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .alpha-block .meta-data span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .alpha-block .meta-data a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .alpha-block .meta-data',
                'scheme' => Typography::TYPOGRAPHY_1
            ]
        );

        $this->end_controls_section();
    }

	protected function __default_style_controls() {
    
        $this->start_controls_section(
            '_section_style_default',
            [
                'label' => __( 'Default', 'editorx-toolkit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'featured_image_default',
			[
				'label' => esc_html__( 'Show featured image', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'editorx-toolkit' ),
				'label_off' => esc_html__( 'Hide', 'editorx-toolkit' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'category_style_default',
			[
				'label' => esc_html__( 'Category style', 'editorx-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  	 => esc_html__( 'Default', 'editorx-toolkit' ),
					'color'  	 => esc_html__( 'Style 1', 'editorx-toolkit' ),
					'background' => esc_html__( 'Style 2', 'editorx-toolkit' ),
				],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .omega-block .categories a',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
		);

		$this->add_control(
            'title_color_default',
            [
                'label' => __( 'Title Color', 'editorx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .omega-block .entry-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .omega-block .entry-title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
            'meta_color_default',
            [
                'label' => __( 'Meta Color', 'editorx-toolkit' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-items .omega-block .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .omega-block .meta-data span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-items .omega-block .meta-data a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_default_typo',
                'selector' => '{{WRAPPER}} .block--posts-items .omega-block .meta-data',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_section();
    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Style', 'editorx-toolkit'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'editorx-toolkit' ),
				'selector' => '{{WRAPPER}} .block--posts-items article .content',
			]
		);

        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-items article .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .block--posts-items article .image-left' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'editorx-toolkit' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-items article .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .block--posts-items article .image-left' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $settings = $this->get_settings_for_display();

		require \Designer::plugin_dir().'widgets/posts-cards/snippets/'.$settings['layout'].'.php';

    }
}