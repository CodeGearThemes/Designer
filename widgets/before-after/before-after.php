<?php

namespace Designer\Widgets\Before_After;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Before_After extends Widget_Base {

	public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'twentytwenty', \Designer::plugin_url().'assets/vendor/twentytwenty/css/twentytwenty.min.css', array(), '1.0.0', 'all' );
        
        wp_register_script( 'twentytwenty', \Designer::plugin_url().'assets/vendor/twentytwenty/js/twentytwenty.min.js', ['elementor-frontend'], '1.0.0', true );
        wp_register_script( 'before-after', \Designer::plugin_url().'widgets/before-after/assets/before-after.js', ['elementor-frontend'], '1.0.0', true );

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
		return 'before-after';
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
		return esc_html__( 'Before & After', 'designer' );
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
			'comparison',
			'Before & after'
		];
	}

	/**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'twentytwenty' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'twentytwenty', 'before-after' ];
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
			'section_name',
			[
				'label' => esc_html( 'Before After Images', 'designer' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'before_image',
			[
				'label' => esc_html( 'Before Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'after_image',
			[
				'label' => esc_html( 'After Image', 'designer' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
			]
		);

        $this->add_control(
			'feature_1',
			[
				'label' => esc_html__( 'Orientation:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
			]
		);

		$this->add_control(
			'feature_2',
			[
				'label' => esc_html__( 'Click to Move:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
			]
		);

        $this->add_control(
			'feature_3',
			[
				'label' => esc_html__( 'Move on Hover:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
			]
		);

		$this->add_control(
			'feature_4',
			[
				'label' => esc_html__( 'Default Offset:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
			]
		);

        $this->add_control(
			'feature_5',
			[
				'label' => esc_html__( 'Overlay on Mouse Hover:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
			]
		);

		$this->add_control(
			'feature_6',
			[
				'label' => esc_html__( 'Need More Options:', 'designer' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 10px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="https://codegearthemes.com/products/designer/" target="_blank" >Buy Pro</a>', 'designer' ),
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
        <div id="block_before_after_<?php echo esc_attr( $this->get_id() ); ?>" class="block-before__after twentytwenty-container">
			<span class='before_text'><?php echo __( 'Before', 'designer' ); ?></span>
			<span class='after_text'><?php echo __( 'After', 'designer' ); ?></span>
            <?php
                echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'before_image' );
                echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'after_image' );
            ?>
		</div>
        <?php
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