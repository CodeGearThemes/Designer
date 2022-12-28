<?php

namespace Designer\Core;

use Designer\Traits\Singleton;
use Designer\Core\Widget_Lists;
use Designer\Framework\Library;
use Designer\Widgets\Breadcrumb\Breadcrumb;

class Helper{

    use Singleton;

    public function posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'knote' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		return '<span class="posted-on">' . $posted_on . '</span>';

	}

    public function author() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'knote' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		return '<span class="byline"> ' . $byline . '</span>';

	}

    /**
     * Post Category
     * @return array
     */
    public function categories(){

        $terms = get_categories( array(
            'hide_empty' => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }

    }


    /**
     * Contact
     * @return array
     */
    public function contact(){

        $contact = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

        $contact_forms = array();
        if ( $contact ) {
            foreach ( $contact as $form ) {
                $contact_forms[$form->ID] = $form->post_title;
            }
        } else {
            $contact_forms[ __( 'No contact forms found', 'designer' ) ] = 0;
        }

        return $contact_forms;

    }

    /**
     * WooCommerce Product Query
     * @return array
     */
    public function woocommerce_product_categories(){
        $terms = get_categories( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
        ));

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }
    }
}

