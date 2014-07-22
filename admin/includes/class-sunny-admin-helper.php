<?php
/**
 * @package 	Sunny
 * @subpackage 	Sunny_Admin
 * @author		Tang Rufus <tangrufus@gmail.com>
 * @license   	GPL-2.0+
 * @link 		http://tangrufus.com
 * @copyright 	2014 Tang Rufus
 * @author 		Tang Rufus <tangrufus@gmail.com>
 */

/**
 *
 * @since 1.1.0
 */
class Sunny_Admin_Helper {
	/**
	 * Get all related links, including tags, categories and all custom taxonomies
	 *
	 * @param   string 		$post_url   The targeted post url
	 *
	 * @return  array 		$urls		The list of all related links
	 *
	 * @see 	http://codex.wordpress.org/Function_Reference/get_the_terms
	 *
	 * @since 	1.1.0
	 */
	static function get_all_terms_links_by_url( $post_url ){
		// get post id
		$post_id = url_to_postid( $post_url );

  		// get post type by post
		$post_type = get_post_type( $post_id );

  		// get all taxonomies for the post type
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );

		$urls = array();
		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

	    	// get the terms related to post
			$terms = get_the_terms( $post_id, $taxonomy_slug );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

				foreach ( $terms as $term) {

					$term_link = get_term_link( $term );

					if ( ! is_wp_error( $term_link ) ) {

						array_push( $urls, $term_link );

					}
				}

			}
		}

		return $urls;
	}
}