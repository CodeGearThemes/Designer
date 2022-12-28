<?php

namespace Designer\Widgets\Popup;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;


class Popup extends Widget_Base{

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'featherlight', \Designer::plugin_url().'assets/vendor/featherlight/css/featherlight.css', array(), '1.7.13', 'all' );

        wp_register_script( 'featherlight', \Designer::plugin_url().'assets/vendor/featherlight/js/featherlight.js', ['jquery','elementor-frontend'], '1.7.13', true );
        wp_register_script( 'simple-popup', \Designer::plugin_url().'widgets/before-after/assets/before-after.js', ['elementor-frontend'], '1.0.23', true );

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
		return 'popup';
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
		return esc_html__( 'Simple Popup', 'designer' );
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
		return 'eicon-image-rollover';
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
            'modal',
            'popup',
			'widget',
			'lightbox',
		];
	}

    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'featherlight' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'featherlight', 'simple-popup' ];
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

        /**
         * Call to Action Content Settings
         */
        $this->start_controls_section(
            '_general_settings',
            [
                'label' => esc_html__('General', 'designer'),
            ]
        );

        $this->add_control(
			'button_label',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button label', 'designer' ),
				'placeholder' => __( 'Click here', 'designer' ),
			]
		);

        $this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'designer' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Type your content here', 'designer' ),
				'placeholder' => esc_html__( 'Type your content here', 'designer' ),
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
            '_section_style_content',
            [
                'label' => __( 'Button', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .block-popup-simple button' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		
		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-popup-simple button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
                    '{{WRAPPER}} .block-popup-simple button' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .block-popup-simple button' => 'background-color: {{VALUE}};border-color: {{VALUE}}',
                ],
            ]
        );
		
		$this->add_control(
            'button_border_color',
            [
                'label' => __( 'Button border color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .block-popup-simple button' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .block-popup-simple button:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .block-popup-simple button:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );
		
		$this->add_control(
            'button_border_hover_color',
            [
                'label' => __( 'Button border hover color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .block-popup-simple button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

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
				'selector' => '{{WRAPPER}} .block-popup-simple .block-lightbox__content',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ..block-popup-simple .block-lightbox__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <div class="block-popup-simple">
            <button data-featherlight="#block-lightbox-<?php echo esc_attr($this->get_id()) ?>">
                <?php echo esc_html( $settings['button_label']) ?>
            </button>
            <div id="block-lightbox-<?php echo esc_attr($this->get_id()) ?>" class="block-lightbox__content" style="display: none;">
                <?php echo $settings['content']; ?>
            </div>
        </div>

        <?php
    }

}
