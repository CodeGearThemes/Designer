<?php

namespace Designer\Widgets\Dual_Header;

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

class Dual_Header extends Widget_Base {

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
		return 'dual-header';
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
		return esc_html__( 'Dual Header', 'designer' );
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
		return 'eicon-t-letter';
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
		return [ 'dual heading', 'heading' ];
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
                    '{{WRAPPER}} .block--dual-header' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'description' => __( 'Add your title here. You can highlight a word using asterisks (eg: Center aligned *section* title)', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
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
        $this->__dual_header_primary_style_controls();
		$this->__dual_header_highlight_style_controls();
    }

    protected function __dual_header_primary_style_controls() {

        $this->start_controls_section(
            '_section_primary_style_item',
            [
                'label' => __( 'Primary Header', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--dual-header .title' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'dual_header_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--dual-header .title',
            ]
        );

        $this->end_controls_section();
    }

	protected function __dual_header_highlight_style_controls() {

		$this->start_controls_section(
            '_section_highlight_style_item',
            [
                'label' => __( 'Highlighted Header', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'title_Highlighted_color',
            [
                'label' => __( 'Highlighted text color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .block--dual-header .title span' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'dual_header_highlight_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--dual-header .title span',
            ]
        );

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'dual_header_highlight_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block--dual-header .title span',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--dual-header .title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label'      => __( 'Padding', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--dual-header .title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'animation_section_bg',
                'label'    => __( 'Section Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block--dual-header .title span',
            ]
        );
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

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'block--dual-header' ],
                ]
            );
        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div class="dual--header-inner">
                    <div class="block-dualheader__item">
                        <?php if( $settings['title'] ): ?>
                            <div class="content-item">
                                <?php
									$title = $settings['title'];
									if ( preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $settings['title'] ) ) {
										$title = preg_replace("/\*([^*]+)\*/", "<span>$1</span>", $settings['title'] );
									}
									if( $settings['title']):
										printf( '<%1$s class="title h1">%2$s</%1$s>',
											tag_escape( $settings['title_tag'], 'h2' ),
											wp_kses_post( $title )
										);
									endif;
								?>
                            </div>
                        <?php endif; ?>
                    </div>
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
    protected function content_template() { }

}
