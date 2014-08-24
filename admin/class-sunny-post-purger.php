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
 * This class takes care the auto purge process.
 */
class Sunny_Post_Purger {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 */
	public function __construct( $name ) {

		$this->name = $name;

	}

	/**
	 * Purge the updated post only if it is published.
	 * Hooked into 'save_post'
	 *
	 * @param    integer    $post_id    The current post being saved
	 *
	 * @return   void
	 *
	 * @since 	 1.0.0
	 */
	private function purge_post( $post_id ) {

		$post_url = get_permalink( $post_id );

		$urls = array();
		array_push( $urls, $post_url );

		if ( '1' == Sunny_Option::get_option( 'purge_homepage' ) ) {

			array_push( $urls, home_url() );

		} // end if

		if ( '1' == Sunny_Option::get_option( 'purge_taxonomies' ) ) {

			$terms_links = Sunny_Helper::get_all_terms_links_by_url( $post_url );
			$urls = array_merge( $urls, $terms_links );

		}

		foreach ( $urls as $url ) {

			Sunny_Purger::purge_cloudflare_cache_by_url( $url );

		}

		return $post_id;

	}

	/**
	 * Purge when post status change from/to `published`
	 *
	 * @param  string 		$new_status 	New Status
	 * @param  string 		$old_status 	Old Status
	 * @param  WP_Object 	$post       	The post
	 *
	 * @return void
	 *
	 * @since  1.4.0
	 */
	public function purge_post_on_status_transition( $new_status, $old_status, $post ) {

		if( 'publish' == $new_status || 'publish' == $old_status ) {

			$this->purge_post( $post->ID );

		}

	}

	/**
	 * Purge when post edited
	 *
	 * @param    integer    $post_id    The current post being saved
	 *
	 * @since 	 1.0.0
	 */
	public function purge_post_on_edit( $post_id ) {

		if ( $this->should_purge( $post_id ) ) {

			$this->purge_post( $post_id );

		}

	}

	/**
	 * Verifies that the user who is currently logged in has permission to save the post
	 * and the post is published.
	 *
	 * @param    integer    $post_id    The current post being saved.
	 *
	 * @return   boolean                True if the user can save the information
	 *
	 * @since 	 1.0.0
	 */
	private function should_purge( $post_id ) {

		$post = get_post( $post_id );

		if ( is_object( $post ) == false ) {

			return false;

		} // end if

		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_published = ( 'publish' == get_post_status( $post_id ) );

		return ! ( $is_autosave || $is_revision ) && $is_published;

	} //end should_purge

}