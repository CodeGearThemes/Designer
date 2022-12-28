<?php
/**
 * Class Breadcrumbs
 * This file does the breadcrumbs handling for the framework.
 *
 * @author     CodeGearThemes
 * @copyright  (c) Copyright by CodeGearThemes
 * @link       https://codegearthemes.com
 * @subpackage Framework
 * @since      1.0.0
 */

namespace Designer\Framework\Library;

use Designer\Framework\Library\Json_Ld;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Handle breadcrumbs.
 */
class Breadcrumbs {

	/**
	 * Current post object.
	 *
	 * @var mixed
	 */
	private $post;

	/**
	 * Prefix for the breadcrumb path.
	 *
	 * @var string
	 */
	private $home_prefix;

	/**
	 * Separator between single breadscrumbs.
	 *
	 * @var string
	 */
	private $separator;

	/**
	 * True if terms should be shown in breadcrumb path.
	 *
	 * @var bool
	 */
	private $show_terms;

	/**
	 * Label for the "Home" link.
	 *
	 * @var string
	 */
	private $home_label;

	/**
	 * Prefix used for pages like date archive.
	 *
	 * @var string
	 */
	private $tag_archive_prefix;

	/**
	 * Prefix used for search page.
	 *
	 * @var string
	 */
	private $search_prefix;

	/**
	 * Prefix used for 404 page.
	 *
	 * @var string
	 */
	private $error_prefix;

	/**
	 * Do ww want to show post-type archives?
	 *
	 * @var bool
	 */
	private $show_post_type_archive;

	/**
	 * The HTML markup.
	 *
	 * @var string
	 */
	private $html_markup = '';

	/**
	 * The breadcrumb array.
	 *
	 * @var array
	 */
	private $breadcrumbs_parts = [];

	/**
	 * The one, true instance of this object.
	 *
	 * @static
	 * @access private
	 * @var null|object
	 */
	private static $instance = null;

	/**
	 * The item position.
	 * An integer that increases as we go deeped in the breadcrumbs.
	 *
	 * @access private
	 * @var int
	 */
	private $item_position = 1;

	/**
	 * Class Constructor.
	 *
	 * @param array $element_args Arguments for element.
	 */
	public function __construct( $element_args = [] ) {

		// Initialize object variables.
		$this->post = get_post( apply_filters( 'breadcrumb_post_id', get_queried_object_id() ) );

		// Setup default array for changeable variables.
		$defaults = [
			'home_prefix'            => '',
			'separator'              => '/',
			'show_post_type_archive' => '',
			'show_terms'             => true,
			'home_label'             => esc_html__( 'Home', 'designer' ),
			'tag_archive_prefix'     => esc_html__( 'Tag:', 'designer' ),
			'search_prefix'          => esc_html__( 'Search:', 'designer' ),
			'error_prefix'           => esc_html__( '404 - Page not Found', 'designer' ),
		];

		// Setup a filter for changeable variables and merge it with the defaults.
		$defaults = apply_filters( 'breadcrumbs_defaults', $defaults );

		if ( ! empty( $element_args ) ) {
			$defaults = wp_parse_args( $element_args, $defaults );
		}

		$this->home_prefix            = $defaults['home_prefix'];
		$this->separator              = $defaults['separator'];
		$this->show_post_type_archive = $defaults['show_post_type_archive'];
		$this->show_terms             = $defaults['show_terms'];
		$this->home_label             = $defaults['home_label'];
		$this->tag_archive_prefix     = $defaults['tag_archive_prefix'];
		$this->search_prefix          = $defaults['search_prefix'];
		$this->error_prefix           = $defaults['error_prefix'];
	}

	/**
	 * Get a unique instance of this object.
	 *
	 * @access public
	 * @since 2.2
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Breadcrumbs();
		}
		return self::$instance;
	}

	/**
	 * Publicly accessible function to get the full breadcrumb HTML markup.
	 *
	 * @access public
	 * @since 2.2
	 * @return void
	 */
	public function get_breadcrumbs() {

		// Support for Yoast Breadcrumbs.
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$this->html_markup = yoast_breadcrumb( '', '', false );
		}

		// Support for RankMath breadcrumbs.
		if ( empty( $this->html_markup ) && function_exists( 'rank_math_get_breadcrumbs' ) ) {
			$this->html_markup = rank_math_get_breadcrumbs( [] );
		}

		//Breadcrumbs.
		if ( empty( $this->html_markup ) ) {
			$this->prepare_breadcrumb_data();
			$this->set_breadcrumbs_output();
		}

		$this->wrap_breadcrumbs();
		$this->output_breadcrumbs_html();
	}

	/**
	 * Publicly accessible function to get breadcrumbs data for element.
	 *
	 * @access public
	 * @since  2.2
	 * @return string HTML output.
	 */
	public function get_element_breadcrumbs() {

		// Support for Yoast Breadcrumbs.
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$this->html_markup = yoast_breadcrumb( '', '', false );
		}

		// Support for RankMath breadcrumbs.
		if ( empty( $this->html_markup ) && function_exists( 'rank_math_get_breadcrumbs' ) ) {
			$this->html_markup = rank_math_get_breadcrumbs( [] );
		}

		// Breadcrumbs.
		if ( empty( $this->html_markup ) ) {
			$this->prepare_breadcrumb_data();
			$this->set_breadcrumbs_output();
		}

		return $this->html_markup;

	}

	/**
	 * Wrap the breadcrumb path in a div.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function wrap_breadcrumbs() {
		$this->html_markup = '<div class="breadcrumbs">' . $this->html_markup . '</div>';
	}

	/**
	 * Output the full breadcrumb HTML markup.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function output_breadcrumbs_html() {
		echo $this->html_markup; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Prepares breadcrumb data.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function prepare_breadcrumb_data() {

		// Add breadcrumb prefix.
		$this->breadcrumbs_parts['prefix'] = $this->get_single_breadcrumb_data( $this->home_prefix, '', false, false, false, '' );

		// Add the "Home" link.
		if ( is_home() && is_front_page() ) { // If the home page is the main blog page.
			$this->breadcrumbs_parts['home'] = $this->get_single_breadcrumb_data( get_the_title( get_option('page_for_posts', true) ), '', true, true, true );
		} else {
			$this->breadcrumbs_parts['home'] = $this->get_single_breadcrumb_data( $this->home_label, get_home_url() );

			// Make sure the breadcrumb does not get doubled up.
			if ( is_front_page() ) {
				return;
			}
		}

		// Woocommerce path prefix (e.g "Shop" ).
		if ( class_exists( 'WooCommerce' ) && ( ( is_archive() && ! is_shop() ) || is_cart() || is_checkout() || is_account_page() ) && $this->show_post_type_archive ) {
			$this->breadcrumbs_parts['shop'] = $this->get_woocommerce_shop_page_data();
		}

		// Single Posts and Pages (of all post types).
		if ( is_singular() ) {

			// If the post type of the current post has an archive link, display the archive breadcrumb.
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( $this->post->post_type ) && $this->show_post_type_archive ) {
				$this->breadcrumbs_parts['post_type_archive'] = $this->get_post_type_archive_data();
			}

			// If the post doesn't have parents.
			if ( isset( $this->post->post_parent ) && 0 == $this->post->post_parent ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
				$this->set_post_terms_data();
			} else {
				// If there are parents; mostly for pages.
				$this->set_post_ancestors_data();
			}

			$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label(), '', false, false, true, '' );

		} else {
			// Blog page is a dedicated page.
			if ( is_home() && ! is_front_page() ) {

				// If TEC events page is set as front page.
				if ( function_exists( 'tribe_is_event_query' ) && tribe_is_event_query() ) {
					return;
				}

				$posts_page                            = get_option( 'page_for_posts' );
				$posts_page_title                      = get_the_title( $posts_page );
				$this->breadcrumbs_parts['posts_page'] = $this->get_single_breadcrumb_data( $posts_page_title, '', true, true, true );
			} elseif ( ( is_tax() || is_tag() || is_category() || is_date() || is_author() ) && $this->show_post_type_archive ) {
				$this->breadcrumbs_parts['post_type_archive'] = $this->get_post_type_archive_data();
			}

			// Custom post types archives.
			if ( is_post_type_archive() ) {
				// Search on custom post type (e.g. Woocommerce).
				if ( is_search() ) {
					$this->breadcrumbs_parts['post_type_archive'] = $this->get_post_type_archive_data();
					$this->breadcrumbs_parts['leaf']              = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'search' ), '', false, false, true, '' );
				} else {
					$this->breadcrumbs_parts['post_type_archive'] = $this->get_post_type_archive_data( false );
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {

				// Taxonomy Archives.
				if ( is_tag() ) {

					// If we have a tag archive, add the tag prefix.
					$this->breadcrumbs_parts['tags_prefix'] = $this->get_single_breadcrumb_data( $this->tag_archive_prefix . ' ', '', false, false, false, '' );
				}
				$this->set_taxonomies_data();
				$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'term' ), '', false, false, true, '' );
			} elseif ( is_date() ) {
				// Date Archives.
				global $wp_locale;
				$year = esc_html( get_query_var( 'year' ) );
				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}

				// Year Archive, only is a leaf.
				if ( is_year() ) {
					$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'year' ), '', false, false, true, '' );
				} elseif ( is_month() ) {

					// Month Archive, needs year link and month leaf.
					$this->breadcrumbs_parts['year'] = $this->get_single_breadcrumb_data( $year, get_year_link( $year ) );
					$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'month' ), '', false, false, true, '' );
				} elseif ( is_day() ) {

					// Day Archive, needs year and month link and day leaf.
					global $wp_locale;

					$month = get_query_var( 'monthnum' );
					if ( ! $month ) {
						$month = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
					}

					$month_name                       = $wp_locale->get_month( $month );
					$this->breadcrumbs_parts['year']  = $this->get_single_breadcrumb_data( $year, get_year_link( $year ) );
					$this->breadcrumbs_parts['month'] = $this->get_single_breadcrumb_data( $month_name, get_month_link( $year, $month ) );
					$this->breadcrumbs_parts['leaf']  = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'day' ), '', false, false, true, '' );
				}
			} elseif ( is_author() ) {

				// Author Archives.
				$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'author' ), '', false, false, true, '' );
			} elseif ( is_search() ) {

				// Search Page.
				$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( 'search' ), '', false, false, false, '' );
			} elseif ( is_404() ) {

				// 404 Page.
				$this->breadcrumbs_parts['leaf'] = $this->get_single_breadcrumb_data( $this->get_breadcrumb_leaf_label( '404' ), '', false, false, false, '' );
			}
		}
	}

	/**
	 * Constructs an array with all information for a single part of a breadcrumbs path.
	 *
	 * @access private
	 * @since 2.2
	 * @param string $label     The label that should be displayed.
	 * @param string $url       The URL of the breadcrumb.
	 * @param bool   $separator Set to TRUE to show the separator at the end of the breadcrumb.
	 * @param bool   $microdata Set to FALSE to make sure we get a link not being part of the breadcrumb microdata path.
	 * @param bool   $is_leaf   Set to TRUE to make sure leaf markup is added to the span.
	 * @param string $prefix    A prefix before the label.
	 * @return array            The data of a single breadcrumb.
	 */
	private function get_single_breadcrumb_data( $label, $url = '', $separator = true, $microdata = true, $is_leaf = false, $prefix = '' ) {
		$breadcrumb_data = [
			'label'     => $label,
			'url'       => $url,
			'prefix'    => $prefix,
			'separator' => $separator,
			'microdata' => $microdata,
			'is_leaf'   => $is_leaf,
		];

		return $breadcrumb_data;
	}

	/**
	 * Returns the markup of a single breadcrumb.
	 *
	 * @access private
	 * @since 2.2
	 * @param array $data The breadcrumb data.
	 * @return string     The HTML markup of a single breadcrumb.
	 */
	private function get_breadcrumb_markup( $data ) {

		$separator_markup = '';
		$leaf_markup      = '';

		// Create JSON-lD for structured data output.
		if ( $data['microdata'] ) {

			// Add item to JSON-LD.
			new Json_Ld(
				'breadcrumbs',
				[
					'@context'        => 'https://schema.org',
					'@type'           => 'BreadcrumbList',
					'itemListElement' => [
						[
							'@type'    => 'ListItem',
							'position' => $this->item_position,
							'name'     => $data['label'],
							'item'     => $data['url'],
						],
					],
				]
			);

			// Increment position.
			$this->item_position++;
		}

		if ( $data['is_leaf'] ) {
			$leaf_markup = ' class="breadcrumb-leaf"';
		}

		$breadcrumb_content = '<span ' . $leaf_markup . '>' . wp_strip_all_tags( $data['label'] ) . '</span>';

		// If a link is set add its markup.
		if ( $data['url'] ) {
			$breadcrumb_content = '<a href="' . esc_url( $data['url'] ) . '" class="breadcrumb-link">' . $breadcrumb_content . '</a>';
		}

		// If a separator should be added, do it.
		if ( $data['separator'] ) {
			$separator_markup = '<span class="breadcrumb-sep">' . $this->separator . '</span>';
		}

		return $data['prefix'] . '<span class="breadcrumb-item">' . $breadcrumb_content . '</span>' . $separator_markup;
	}

	/**
	 * Returns the full breadcrumbs markup.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function set_breadcrumbs_output() {
		$this->html_markup = '';

		// Loop through the main data array.
		foreach ( $this->breadcrumbs_parts as $type => $data ) {
			$prefix = '';

			// Prefix of breadcrumbs.
			if ( 'prefix' === $type ) {

				// Add chosen path prefix, if the home page is a real page.
				if ( ! is_front_page() && ! empty( $data['label'] ) ) {
					$this->html_markup .= '<span class="breadcrumb-prefix">' . $this->get_breadcrumb_markup( $data ) . ':</span>';
				}
			} elseif ( ! empty( $data['label'] ) ) {
				$this->html_markup .= $this->get_breadcrumb_markup( $data );
			}
		}
	}

	/**
	 * Gets the data of the woocommerce shop page.
	 *
	 * @access private
	 * @since 2.2
	 * @param  bool $linked Linked or not linked.
	 * @return string The HTML markup of the woocommerce shop page.
	 */
	private function get_woocommerce_shop_page_data( $linked = true ) {
		global $wp_query;

		$post_type        = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$shop_page_markup = '';
		$link             = '';

		// Make sure we are on a woocommerce page.
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			// Get shop page id and then its name.
			$shop_page_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

			// Use the archive name if no shop page was set.
			if ( ! $shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}

			// Check if the breadcrumb should be linked.
			if ( $linked ) {
				$link = get_post_type_archive_link( $post_type );
			}

			$separator = ! is_shop();
			$is_leaf   = is_shop();

			if ( is_search() ) {
				$separator = true;
				$is_leaf   = false;
			}
			$shop_page_markup = $this->get_single_breadcrumb_data( $shop_page_name, $link, $separator, true, $is_leaf );
		}

		return $shop_page_markup;
	}

	/**
	 * Gets the data of a post type archive.
	 *
	 * @access private
	 * @since 2.2
	 * @param  string $linked Linked or not linked.
	 * @return array The data of the post type archive.
	 */
	private function get_post_type_archive_data( $linked = true ) {
		global $wp_query;

		$link          = '';
		$archive_title = '';

		$post_type = $wp_query->query_vars['post_type'];
		if ( ! $post_type ) {
			$post_type = get_post_type();
		}
		$post_type_object = get_post_type_object( $post_type );

		// Check if we have a post type object.
		if ( is_object( $post_type_object ) ) {

			// Woocommerce: archive name should be same as shop page name.
			if ( 'product' === $post_type ) {
				return $this->get_woocommerce_shop_page_data( $linked );
			}

			// Use its name as fallback.
			$archive_title = $post_type_object->name;
			// Default case. Check if the post type has a non empty label.
			if ( isset( $post_type_object->label ) && '' !== $post_type_object->label ) {
				$archive_title = $post_type_object->label;
			} elseif ( isset( $post_type_object->labels->menu_name ) && '' !== $post_type_object->labels->menu_name ) {
				// Alternatively check for a non empty menu name.
				$archive_title = $post_type_object->labels->menu_name;
			}
		}

		// Check if the breadcrumb should be linked.
		if ( $linked ) {
			$link = get_post_type_archive_link( $post_type );
		}

		return $this->get_single_breadcrumb_data( $archive_title, $link );
	}

	/**
	 * Construct the full term ancestors tree path and add it to the main data array.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function set_taxonomies_data() {
		global $wp_query;
		$term         = $wp_query->get_queried_object();
		$terms_markup = '';

		// Make sure we have hierarchical taxonomy and parents.
		if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
			$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			$term_ancestors = array_reverse( $term_ancestors );

			// Loop through ancestors to get the full tree.
			foreach ( $term_ancestors as $term_ancestor ) {
				$term_object = get_term( $term_ancestor, $term->taxonomy );
				$this->breadcrumbs_parts[ 'term_' . $term_object->term_id ] = $this->get_single_breadcrumb_data( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}
	}

	/**
	 * Construct the full post term tree path and adds the data to the main array.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function set_post_terms_data() {

		// If terms are disabled, nothing is to do.
		if ( ! $this->show_terms ) {
			return;
		}

		// Get the post terms.
		if ( 'post' === $this->post->post_type ) {
			$taxonomy = 'category';
		} elseif ( 'portfolio' === $this->post->post_type ) {
			//Portfolio.
			$taxonomy = 'portfolio_category';
		} elseif ( 'product' === $this->post->post_type && class_exists( 'WooCommerce' ) ) {
			// Woocommerce.
			$taxonomy = 'product_cat';
		} else {
			// For other post types don't return a terms tree to reduce possible errors.
			return;
		}

		$terms = wp_get_object_terms( $this->post->ID, $taxonomy );

		// If post does not have any terms assigned; possible e.g. portfolio posts.
		if ( empty( $terms ) ) {
			return;
		}

		// Check if the terms are all part of one term tree, i.e. only related terms are selected.
		$terms_by_id = [];
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		// Unset all terms that are parents of some term.
		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		// If only one term is left, we have a single term tree.
		if ( 1 === count( $terms_by_id ) ) {
			unset( $terms );
			$terms[0] = array_shift( $terms_by_id );
		}

		// The post is only in one term.
		if ( 1 === count( $terms ) ) {

			$term_parent = $terms[0]->parent;

			// If the term has a parent we need its ancestors for a full tree.
			if ( $term_parent ) {
				// Get space separated string of term tree in slugs.
				$term_tree   = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree   = array_reverse( $term_tree );
				$term_tree[] = get_term( $terms[0]->term_id, $taxonomy );

				// Loop through the term tree.
				foreach ( $term_tree as $term_id ) {
					// Get the term object by its slug.
					$term_object = get_term( $term_id, $taxonomy );

					// Add it to the term breadcrumb markup string.
					$this->breadcrumbs_parts[ 'term_' . $term_object->term_id ] = $this->get_single_breadcrumb_data( $term_object->name, get_term_link( $term_object ) );
				}
			} else {

				// We have a single term, so put it out.
				$this->breadcrumbs_parts[ 'term_' . $terms[0]->term_id ] = $this->get_single_breadcrumb_data( $terms[0]->name, get_term_link( $terms[0] ) );
			}
		} else { // The post has multiple terms.

			// Add a parent term, if all children share the same parent.
			foreach ( $terms as $term ) {
				$term_parents[] = $term->parent;
			}

			if ( 1 === count( array_unique( $term_parents ) ) && $term_parents[0] ) {

				// Get space separated string of term tree in slugs.
				$term_tree = get_ancestors( $terms[0]->term_id, $taxonomy );
				$term_tree = array_reverse( $term_tree );

				// Loop through the term tree.
				foreach ( $term_tree as $term_id ) {
					// Get the term object by its slug.
					$term_object = get_term( $term_id, $taxonomy );

					// Add term term breadcrumb data array.
					$this->breadcrumbs_parts[ 'term_' . $term_id ] = $this->get_single_breadcrumb_data( $term_object->name, get_term_link( $term_object ) );
				}
			}

			// The lexicographically smallest term will be part of the breadcrumb microdata path.
			$this->breadcrumbs_parts['term_microdata'] = $this->get_single_breadcrumb_data( $terms[0]->name, get_term_link( $terms[0] ), false );

			// Drop the first index.
			array_shift( $terms );

			// Loop through the rest of the terms, and add them to string comma separated.
			$max_index = count( $terms );
			$i         = 0;
			foreach ( $terms as $term ) {

				// For the last index also add the separator.
				if ( ++$i === $max_index ) {
					$this->breadcrumbs_parts[ 'term_sibling_' . $term->term_id ] = $this->get_single_breadcrumb_data( $term->name, get_term_link( $term ), true, false, false, ', ' );
				} else {
					$this->breadcrumbs_parts[ 'term_sibling_' . $term->term_id ] = $this->get_single_breadcrumb_data( $term->name, get_term_link( $term ), false, false, false, ', ' );
				}
			}
		}
	}

	/**
	 * Construct the full post ancestors tree path and add it to the main data array.
	 *
	 * @access private
	 * @since 2.2
	 * @return void
	 */
	private function set_post_ancestors_data() {
		$ancestors_markup = '';

		// Get the ancestor id, order needs to be reversed.
		$post_ancestor_ids = array_reverse( get_post_ancestors( $this->post ) );

		// Loop through the ids to get the full tree.
		foreach ( $post_ancestor_ids as $post_ancestor_id ) {
			$post_ancestor = get_post( $post_ancestor_id );

			if ( isset( $post_ancestor->post_title ) && isset( $post_ancestor->ID ) ) {
				$this->breadcrumbs_parts[ 'post_ancestor_' . $post_ancestor->ID ] = $this->get_single_breadcrumb_data( apply_filters( 'the_title', $post_ancestor->post_title, $post_ancestor->ID ), get_permalink( $post_ancestor->ID ) );
			}
		}
	}

	/**
	 * Gets the label for the breadcrumb leaf.
	 *
	 * @access private
	 * @since 2.2
	 * @param  string $object_type ID of the current query object.
	 * @return string              The label for the breadcrumb leaf.
	 */
	private function get_breadcrumb_leaf_label( $object_type = '' ) {
		global $wp_query, $wp_locale;

		switch ( $object_type ) {
			case 'term':
				$term  = $wp_query->get_queried_object();
				$label = $term->name;
				break;
			case 'year':
				$year = esc_html( get_query_var( 'year', 0 ) );
				if ( ! $year ) {
					$year = substr( esc_html( get_query_var( 'm' ) ), 0, 4 );
				}
				$label = $year;
				break;
			case 'month':
				$monthnum = get_query_var( 'monthnum', 0 );
				if ( ! $monthnum ) {
					$monthnum = substr( esc_html( get_query_var( 'm' ) ), 4, 2 );
				}
				$label = $wp_locale->get_month( $monthnum );
				break;
			case 'day':
				$day = get_query_var( 'day' );
				if ( ! $day ) {
					$day = substr( esc_html( get_query_var( 'm' ) ), 6, 2 );
				}
				$label = $day;
				break;
			case 'author':
				$user = $wp_query->get_queried_object();
				if ( ! $user ) {
					$user = get_user_by( 'ID', $wp_query->query_vars['author'] );
				}
				$label = $user->display_name;
				break;
			case 'search':
				$label = $this->search_prefix . ' ' . esc_html( get_search_query() );
				break;
			case '404':
				$label = $this->error_prefix;
				break;
			default:
				$label = $this->post ? get_the_title( $this->post->ID ) : get_the_title();
				break;
		}

		return $label;
	}
}

