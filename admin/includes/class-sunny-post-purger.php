<?php
/**
 *
 * @package   Sunny
 * @author    Tang Rufus <tangrufus@gmail.com>
 * @license   GPL-2.0+
 * @link      http://tangrufus.com
 * @copyright 2014 Tang Rufus
 */

/**
 * Take care the purge process fired from the admin dashboard.
 *
 * @package Sunny_Admin_Helper
 * @author  Tang Rufus <tangrufus@gmail.com>
 */
class Sunny_Post_Purger {

	/**
	 * Purge the updated post only if it is published.
	 * Hooked into 'save_post'
	 *
	 * @param    integer    $post_id    The current post being saved
	 *
	 * @since 	 1.0.0
	 *
	 */
	public static function purge_after_save( $post_id ) {
		Sunny_API_Debugger::write_triggered_report( 'save_post hook' );

		if( self::should_purge( $post_id ) ) {
			Sunny_Purger::purge_cloudflare_cache_by_url( get_permalink( $post_id ) );
		}
	}

	/**
	 * Verifies that the user who is currently logged in has permission to save the post
	 * and the post is published.
	 *
	 * @since 	 1.0.0
	 *
	 * @param    integer    $post_id    The current post being saved.
	 * @return   boolean                True if the user can save the information
	 */
	private static function should_purge( $post_id ) {

	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_published = ( get_post_status( $post_id ) == 'publish' );

	    return ! ( $is_autosave || $is_revision ) && $is_published;

	}

}