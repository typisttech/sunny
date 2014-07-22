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
 * This class takes care the purge process fired from the admin dashboard.
 */
class Sunny_Post_Purger {
	/**
     * Instance of this class.
     *
     * @since    1.0.4
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class and purge after post saved
     *
     * @since     1.0.4
     */
    private function __construct() {
		add_action( 'save_post', array( $this, 'purge_after_save' ) );
	}

    /**
     * Return an instance of this class.
     *
     * @since     1.0.4
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

	/**
	 * Purge the updated post only if it is published.
	 * Hooked into 'save_post'
	 *
	 * @param    integer    $post_id    The current post being saved
	 *
	 * @since 	 1.0.0
	 */
	public function purge_after_save( $post_id ) {
		if ( $this->should_purge( $post_id ) ) {
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
	 *
	 * @return   boolean                True if the user can save the information
	 */
	private function should_purge( $post_id ) {
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_published = ( 'publish' == get_post_status( $post_id ) );

	    return ! ( $is_autosave || $is_revision ) && $is_published;
	}
}