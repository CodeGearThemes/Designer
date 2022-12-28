<?php

namespace Designer\Widgets\Posts_Sliderx;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Designer\Core\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;


class Posts_Sliderx extends Widget_Base{

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);

        wp_register_script( 'posts-slider', \Designer::plugin_url().'widgets/posts-sliderx/assets/post-slider.js', array('swiper','elementor-frontend'), '1.0.0', true );

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
		return 'posts-slider';
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
		return esc_html__( 'Posts Slider', 'designer' );
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
		return 'eicon eicon-slides';
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
			'Posts Carousel',
			'Posts Slider',
            'CodegearThemes',
		];
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
        return [ 'posts-slider' ];
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
            'layout',
            array(
                'label'       => esc_html__( 'Layout:', 'designer' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'default'       =>  'default',
                'options'      => array(
					'default'   => esc_html__('Default','designer'),
                )
            )
        );

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay?', 'designer' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'designer' ),
				'label_off' => __( 'No', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
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
			'navigation',
			[
				'label' => __( 'Navigation', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'None', 'designer' ),
					'arrow' => __( 'Arrow', 'designer' )
				],
				'default' => 'arrow',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'_unqid',
			[
				'label' => esc_html__( 'Carousel selector', 'designer' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => uniqid(),
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
		$this->__title_style_controls();
		$this->__general_style_controls();
		$this->__arrow_style_controls();
    }

	protected function __general_query_controls() {

		$this->start_controls_section(
            '_query_settings',
            [
                'label' => esc_html__('Query', 'designer'),
            ]
        );

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Select Category', 'designer' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => Helper::instance()->categories(),
			]
		);

		$this->add_control(
			'post_per_page',
			[
				'label' => esc_html__( 'Post per page', 'designer' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_responsive_control(
            'image_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'designer'),
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
                    '{{WRAPPER}} .block--posts-slider article .image-main' => 'padding-bottom: calc( {{size}} * 100% );',
                ],
                'description' => esc_html__("Not applicable for Featured Layouts.", "designer"),
            ]
        );

		$this->add_control(
			'author',
			[
				'label' => esc_html__( 'Show Author', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date',
			[
				'label' => esc_html__( 'Show Date', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cat',
			[
				'label' => esc_html__( 'Show Categories', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'designer' ),
				'label_off' => esc_html__( 'Hide', 'designer' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();
	}

	protected function __title_style_controls() {

        $this->start_controls_section(
            '_section_style_general',
            [
                'label' => __( 'General', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'category_style',
			[
				'label' => esc_html__( 'Category style', 'designer' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  	 => esc_html__( 'Default', 'designer' ),
					'color'  	 => esc_html__( 'Style 1', 'designer' ),
					'background' => esc_html__( 'Style 2', 'designer' ),
				],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typo',
                'selector' => '{{WRAPPER}} .block--posts-slider .categories a',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
		);

		$this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-slider .entry-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .block--posts-slider .entry-title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
            'meta_color',
            [
                'label' => __( 'Meta Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .block--posts-slider .meta-data' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-slider .meta-data span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .block--posts-slider .meta-data a' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typo',
                'selector' => '{{WRAPPER}} .block--posts-slider .meta-data',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_section();
    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Style', 'designer'),
				'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block--posts-slider .post--slider-item',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px'
                ],
				'selectors' => [
					'{{WRAPPER}} .block--posts-slider .post--slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

	protected function __arrow_style_controls() {

        $this->start_controls_section(
            '_section_style_arrow',
            [
                'label' => __( 'Navigation', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

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
                'label' => __( 'Icon Color', 'designer' ),
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
                'label' => __( 'Icon Color', 'designer' ),
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
	protected function render() {

        $settings = $this->get_settings_for_display();
		$loop = $settings['loop'];
        $autoplay = $settings['autoplay'];
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'block--posts-slider', $settings['layout'] ],
                'data-selector' => $settings['_unqid'],
                'data-autoplay' => $autoplay,
                'data-loop' => $loop,
            ]
        );

        $categories = $settings['categories'];
        $args = [
            'posts_per_page' => $settings['post_per_page'],
			'category__in' => $categories
        ];

        $query = new \WP_Query($args); ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="block_postslider_<?php echo $settings['_unqid'] ?>" class="swiper">
				<div class="posts-inner swiper-wrapper">
					<?php
						while ( $query->have_posts() ) : $query->the_post();
							$categories = get_the_category( get_the_ID() ); ?>
							<div class="post--slider-item swiper-slide slider-slide">
								<article id="post-<?php the_ID(); ?>" <?php post_class('post-grid'); ?>>
									<div class="content">
										<?php if ( has_post_thumbnail() ) { ?>
											<div class="image-main">
												<a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
													<?php the_post_thumbnail( 'full' );  ?>
												</a>
											</div>
										<?php } ?>
										<div class="entry-header">
											<?php
												if ( ! empty( $categories ) && $settings['show_cat'] ) { ?>
													<div class="categories <?php echo 'schema-'.$settings['category_style']; ?>">
														<?php foreach( $categories as $category ) {
															$meta = get_term_meta( $category->term_id, '_taxonomy_options', true ); ?>
															<a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>"
																<?php if( isset( $meta['color_schema'] ) ): ?>
																	<?php if( $settings['category_style'] == 'default' ): ?>
																		style="color: <?php echo $meta['color_schema']['color'] ?>; background: <?php echo $meta['color_schema']['background'] ?>"
																	<?php elseif( $settings['category_style'] == 'color' ): ?>
																		style="color: <?php echo $meta['color_schema']['color'] ?>"
																	<?php elseif( $settings['category_style'] == 'background' ): ?>
																		style="color: <?php echo $meta['color_schema']['background'] ?>"
																	<?php endif; ?>
																<?php endif; ?>
															>
															<?php echo esc_html( $category->name ); ?></a>
														<?php } ?>
													</div>
													<?php
												}
												the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
											?>
											<?php if( $settings['date'] || $settings['author'] ): ?>
												<div class="meta-data">
													<?php
														if( $settings['author'] )
														\Designer\Core\Helper::instance()->author(); ?>
													<?php
														if( $settings['date'] )
														\Designer\Core\Helper::instance()->posted_on(); ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</article>
							</div>
						<?php
						endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
			<?php if( $settings['navigation'] == 'arrow' ): ?>
                <div class="slide-previous swiper-button-prev-<?php echo $settings['_unqid'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-left">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </div>
                <div class="slide-next swiper-button-next-<?php echo $settings['_unqid'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-chevron-right">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </div>
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
    protected function content_template() {}
}
