<?php
/**
 * Fired public and other codes and methods
 *
 * @link       http://majeed21.com
 * @since      1.0.0
 *
 * @package    calendar-event-jquery
 * @subpackage calendar-event-jquery/inc
 * @author     Majeed Mohammadian <majeedmohammadian@gmail.com>
 */

class CEJ_Frontend {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
    {
        global $obj_assets;

        // add script frontend
        add_action('wp_enqueue_scripts', array($obj_assets, 'frontend_scripts'));

        // add style frontend
        add_action('wp_enqueue_scripts', array($obj_assets, 'frontend_styles'));
	}

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
        global $obj_frontend;
        unset($obj_frontend);
    }
}