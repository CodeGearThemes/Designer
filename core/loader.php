<?php

namespace Designer\Core;

use Designer\Traits\Singleton;
use Designer\Core\Widget_Lists;

class Loader{

    use Singleton;

   /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function __construct() {
        add_action( 'elementor/controls/register', array( $this, 'register_elementor_control' ), 10 );
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_elementor_widgets'] );
        add_action( 'elementor/widgets/register', [ $this, 'unregister_widgets' ] );

        add_action('wp_footer', [ $this, 'register_styles' ]);
    }

    /**
	 * Elementor Categories
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function add_elementor_widget_categories( $elements_manager ) {
        
        $elements_manager->add_category(
            'designer',
            [
                'title' => esc_html__( 'Designer', 'designer' ),
                'icon' => 'fa fa-cube',
            ]
        );
    
    }

    public function register_elementor_control( $controls_manager ) {
		$controls_manager->register( new \Designer\Core\Modules\Image_Select() );
	}

    public function register_styles(){
        wp_enqueue_style( 'designer-style', \Designer::plugin_url().'assets/public/css/main.css', array(), '1.0.0', 'all' );
    }


    /**
	 * Elementor Widgets
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function register_elementor_widgets( $widgets_manager ) {

        Widget_Lists::instance()->register_widget( $widgets_manager );

    }


    /**
     * Unregister Elementor widgets.
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     * @return void
     */
    function unregister_widgets( $widgets_manager ) {

        $widgets_manager->unregister( 'element--promotion' );

    }
}