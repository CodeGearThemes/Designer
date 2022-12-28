<?php

namespace Designer\Widgets\Gallery;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Gallery extends Widget_Base{

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
        wp_register_style( 'lightboxed', \Designer::plugin_url().'assets/vendor/lightboxed/css/lightboxed.css', array(), '1.0.0', 'all' );
        
        wp_register_script( 'lightboxed', \Designer::plugin_url().'assets/vendor/lightboxed/js/lightboxed.min.js', ['jquery','elementor-frontend'], '1.0.0', true );
        wp_register_script( 'gallery-images', \Designer::plugin_url().'widgets/before-after/assets/before-after.js', ['elementor-frontend'], '1.0.0', true );

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
		return 'gallery';
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
		return esc_html__( 'Gallery', 'designer' );
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
		return 'eicon-gallery-grid';
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
            'photo',
			'widget',
			'gallery',
		];
	}

    /**
     * Widget Style.
     *
     * @return string
     */
    public function get_style_depends() {
        return [ 'lightboxed' ];
    }

    /**
     * Widget script.
     *
     * @return string
     */
    public function get_script_depends() {
        return [ 'lightboxed', 'gallery-images' ];
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
			'gallery',
			[
				'label' => esc_html__( 'Add Images', 'designer' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'show_label' => false,
				'default' => [],
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

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'designer' ),
				'selector' => '{{WRAPPER}} .block-gallery-images .image-item',
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'designer' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-gallery-images .image-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <div class="block-gallery-images">
            <ul class="gallery-inner">
                <?php foreach ( $settings['gallery'] as $image )  : ?>
                    <?php 
                        $img = wp_get_attachment_image_src( $image['id'], 'full' );
                        $imagesm = wp_get_attachment_image_src( $image['id'], array( 300, 300 ) );
                        $image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true);
						$image_cation = wp_get_attachment_caption( $image['id'] );
                        $class = 'image-portrait';
                        if( $img[1] > $img[2] ){
                            $class = 'image-landscape';
                        }

                        if( $img[1] >  ( 1.5 * absint( $img[2] ) ) ){
                            $class = 'image-landscape image-landscape__large';
                        }
                    ?>
					<li class="lightboxed <?php echo esc_attr( $class ); ?>" rel="<?php echo esc_attr($this->get_id()) ?>" data-link="<?php echo esc_url( $img[0] ); ?>" 
						<?php if( $image_caption != '' ): ?>data-caption="<?php esc_attr( $image_caption ); ?>" <?php endif; ?>>
                    	<img loading="lazy" width="<?php echo absint( $imagesm[1] ); ?>" height="<?php echo absint( $imagesm[2] ); ?>" class="image-item"
                         src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr($image_alt); ?>"/>
					</li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php
    }

}