<?php

namespace Designer\Widgets\Breadcrumb;


use Designer\Core\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Designer\Framework\Library\Breadcrumbs;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Breadcrumb extends Widget_Base {

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
		return 'breadcrumb';
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
		return esc_html__( 'Breadcrumb', 'designer' );
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
		return 'eicon-yoast';
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
		return [ 'breadcrumb', 'navigation' ];
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
				'label' => __( 'Breadcrumb', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
            'alignment',
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
                    '{{WRAPPER}} .breadcrumbs' => 'justify-content: {{VALUE}}'
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
		$this->__breadcrumb_style_controls();
	}

	protected function __breadcrumb_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => __( 'Style', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label',
                'selector' => '{{WRAPPER}} .block-breadcrumb .breadcrumbs',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

		$this->add_control(
            'color',
            [
                'label' => __( 'Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-breadcrumb .breadcrumbs .breadcrumb-item' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'color_link',
            [
                'label' => __( 'Link color ', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-breadcrumb .breadcrumbs .breadcrumb-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
            'seperator_color',
            [
                'label' => __( 'Seperator Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-breadcrumb .breadcrumbs .breadcrumb-sep' => 'color: {{VALUE}};',
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
		?>
		<div class="block-breadcrumb">
			<div class="breadcrumb-inner__wrapper">
				<?php Breadcrumbs::get_instance()->get_breadcrumbs(); ?>
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
