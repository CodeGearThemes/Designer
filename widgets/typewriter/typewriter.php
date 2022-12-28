<?php

namespace Designer\Widgets\Typewriter;

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

class Typewriter extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_script( 'typewriter', \Designer::plugin_url().'widgets/typewriter/assets/typewriter.js', array('elementor-frontend'), '1.0.0', true );

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
		return 'typewriter';
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
		return esc_html__( 'Typewriter', 'designer' );
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
		return 'eicon-animated-headline';
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
		return [ 'Typewriter Text', 'heading' ];
	}

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'typewriter' ];
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
                    '{{WRAPPER}} .block--typewriter-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'title_before',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title before', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'title',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' )
			]
		);

        $this->add_control(
			'typewriters',
			[
				'label'       => __( 'Typewriter Text', 'designer' ),
				'show_label' => true,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(title || "Typewriter Text"); #>',
                'default' => array_fill( 0, 1, [
                    'title' => __( 'Designer', 'designer' ),
				])
			]
		);

        $this->add_control(
			'title_after',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Title after', 'designer' ),
				'placeholder' => __( 'Type title here', 'designer' ),
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
        $this->__typewriter_title_before_style_controls();
		$this->__typewriter_text_style_controls();
		$this->__typewriter_cursor_style_controls();
		$this->__typewriter_title_after_style_controls();
    }

    protected function __typewriter_title_before_style_controls() {

        $this->start_controls_section(
            '_section_title_before_style_item',
            [
                'label' => __( 'Title Before', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_before_color',
            [
                'label' => __( 'Title Before Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .title-before' => 'color: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_before_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--typewriter-text .title-text .title-before',
            ]
        );

        $this->end_controls_section();
    }

	protected function __typewriter_text_style_controls() {

		$this->start_controls_section(
			'_section_typewriter_style_item',
			[
				'label' => __( 'Typewriter Text', 'designer' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'typewriter_color',
			[
				'label' => __( 'Typewriter Text Color', 'designer' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typewriter_text_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .block--typewriter-text .title-text .typewrite',
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'typewriter_text_border',
                'label'    => __( 'Box Border', 'designer' ),
                'selector' => '{{WRAPPER}} .block--typewriter-text .title-text .typewrite',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __( 'Border Radius', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_margin',
            [
                'label'      => __( 'Margin', 'designer' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'animation_section_bg',
                'label'    => __( 'Section Background', 'designer' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block--typewriter-text .title-text .typewrite',
            ]
        );

		$this->end_controls_section();
	}

	protected function __typewriter_cursor_style_controls() {

		$this->start_controls_section(
            'typewriter_cursor_style',
            [
                'label' => __( 'Cursor Control', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cursor_color',
            [
                'label'     => __( 'Color', 'designer' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#54595f',
                'selectors' => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'border-right: solid {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cursor_width',
            [
                'label'      => __( 'Width', 'designer' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .typewrite' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function __typewriter_title_after_style_controls() {

        $this->start_controls_section(
            '_section_title_after_style_item',
            [
                'label' => __( 'Title After', 'designer' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_after_color',
            [
                'label' => __( 'Title After Color', 'designer' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .block--typewriter-text .title-text .title-after' => 'color: {{VALUE}};'
                ]
            ]
        );

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_after_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block--typewriter-text .title-text .title-after',
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

            $this->add_render_attribute(
                'wrapper',
                [
                    'class' => [ 'block--typewriter-text' ],
                ]
            );

            $title = array();
            foreach ( $settings['typewriters'] as $text ):
                $title[] = $text['title'];
            endforeach;
            $title = json_encode( $title );

        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div class="typewriter-title-inner">
                    <div class="block-typewriter__item">
                        <?php if( $settings['title_before'] || !empty( $settings['typewriters'] ) || $settings['title_after'] ): ?>
                            <h2 class="title-text">
                                <?php if( $settings['title_before'] ): ?>
                                    <span class= "title-before"><?php echo wp_kses_post($settings['title_before']); ?></span>
                                <?php endif ?>

                                <?php if( !empty( $settings['typewriters'] ) ): ?>
                                    <span class="typewrite" data-period="2000" data-type="<?php echo esc_attr($title); ?>"></span>
                                <?php endif ?>

                                <?php if( $settings['title_after'] ): ?>
                                    <span class="title-after"><?php echo wp_kses_post($settings['title_after']); ?></span>
                                <?php endif ?>
                                </h2>
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
