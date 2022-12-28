<?php

namespace Designer\Widgets\Images;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;


class Images extends Widget_Base{

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
		return 'images';
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
		return esc_html__( 'Stack Images', 'designer' );
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
		return 'eicon-image';
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
			'images',
			'stack',
            'photo',
            'CodegearThemes',
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

        /**
         * Call to Action Content Settings
         */
        $this->start_controls_section(
            '_general_settings',
            [
                'label' => esc_html__('Settings', 'designer'),
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

        $repeater = new Repeater();

        $repeater->add_control(
			'stack_image',
			[
                'label' => __( 'Stack Image', 'designer' ),
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
				'name' => 'stack_thumb',
				'default' => 'full',
				'separator' => 'before',
				'exclude' => [
					'custom'
				]
			]
		);

        $repeater->add_responsive_control(
            'horizontal_alignment',
            [
                'label' => __( 'Alignment', 'designer' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'designer' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'designer' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'designer' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .block-stack-images .image-item' => 'justify-content: {{VALUE}}'
                ]
            ]
        );

		$repeater->add_control(
            'position',
            [
                'label' => __( 'Position', 'designer' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __( 'None', 'designer' ),
                'label_on' => __( 'Custom', 'designer' ),
                'return_value' => 'yes',
            ]
        );

        $repeater->start_popover();

        $repeater->add_responsive_control(
            'position_v',
            [
                'label' => __( 'Vertical', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'position' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -300,
                        'max' => 300,
                    ],
                ],
				'default' => [
					'size' => 10,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .block-stack-images .image-item' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'position_x',
            [
                'label' => __( 'Horizontal', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'horizontal_alignment' => 'left',
                    'position' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -300,
                        'max' => 300,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'size' => -10,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .block-stack-images .image-item' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'position_right_x',
            [
                'label' => __( 'Horizontal', 'designer' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'horizontal_alignment' => 'right',
                    'position' => 'yes'
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => -300,
                        'max' => 300,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'size' => -10,
					'unit' => '%',
				],
                'selectors' => [
                    '{{WRAPPER}} .block-stack-images .image-item' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$repeater->end_popover();

        $this->add_control(
			'images',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print( "Stack image"); #>',
                'default' => array_fill( 0, 1, [
                    'stack_image' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
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
		$this->__general_style_controls();
    }

    protected function __general_style_controls() {

        $this->start_controls_section(
            '_style_settings',
            [
                'label' => esc_html__('Style', 'designer'),
                'tab'   => Controls_Manager::TAB_STYLE,
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

        <div class="block-stack-images">
            <div class="stack-images">
                <?php
                    $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
                    $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
                    $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
                    $this->add_render_attribute( 'image', 'class', 'image' );
                ?>

                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
                <?php foreach ( $settings['images'] as $stack ) : ?>
                    <div class="image-item <?= esc_attr($stack['horizontal_alignment']); ?>">
                        <?php
                            $this->add_render_attribute( 'stack_image', 'src', $stack['stack_image']['url'] );
                            $this->add_render_attribute( 'stack_image', 'alt', \Elementor\Control_Media::get_image_alt( $stack['stack_image'] ) );
                            $this->add_render_attribute( 'stack_image', 'title', \Elementor\Control_Media::get_image_title( $stack['stack_image'] ) );
                            $this->add_render_attribute( 'stack_image', 'class', 'image' );
                        ?>

                        <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $stack, 'stack_thumb', 'stack_image' ); ?>
                </div>
                <?php endforeach; ?>
                </div>
        </div>

        <?php
    }


}
