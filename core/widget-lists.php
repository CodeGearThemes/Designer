<?php

namespace Designer\Core;

use Elementor\Plugin;
use Designer\Traits\Singleton;

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class Widget_Lists {

    use Singleton;

    public function register_widget( $widgets_manager ) {

        $widgets = [
            'pricing-table',
            'drop-cap',
            'social',
            'slider',
            'images',
            'clients',
            'popup',
            'gallery',
            'team-card',
            'typewriter',
            'posts-cards',
            'post-slider',
            'post-carousel',
            'before-after',
            'testimonial',
            'dual-header',
            'scroll-down',
            'breadcrumb',
            'testimonial-slider',
        ];

        foreach ( $widgets as $widget ) {

            $class_name = str_replace( '-', '_', $widget );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = '\\Designer\\Widgets\\'.$class_name.'\\'.$class_name;

            if( class_exists($class_name) ){
				$widgets_manager->register( new $class_name() );
			}
        }
    }

}
