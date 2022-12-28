<?php

namespace Designer\Core\Elementor;

use Designer\Traits\Singleton;

class Elementor{

    use Singleton;

    public function __construct() {

        add_action('wp_footer', [ $this, 'register_styles' ]);
        add_action('elementor/editor/before_enqueue_styles', [ $this, 'elementor_custom_style'] );

    }

    public function register_styles(){

        wp_register_style( 'swiper', \Designer::plugin_url().'assets/vendor/swiper/css/swiper-bundle.min.css', array(), '7.0.1', 'all' );

    }

    public function elementor_custom_style() { ?>
        <style>
          #elementor-panel-category-pro-elements,
          #elementor-panel-category-theme-elements,
          #elementor-panel-category-woocommerce-elements .elementor-element--promotion{
              display: none !important;
          }

          #elementor-panel-category-header .elementor-element::after,
          #elementor-panel-category-designer .elementor-element::after,
          #elementor-panel-category-footer .elementor-element::after{
            content: "";
            width: 20px;
            height: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #fff;
            background-size: 100%;
            border-radius: 5px;
            background-image: url(<?php echo esc_url(\Designer::plugin_url().'assets/src/icon.png'); ?>);
          }
        </style>
    <?php
    }

}
