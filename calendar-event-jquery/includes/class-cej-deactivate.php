<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://majeed21.com
 * @since      1.0.0
 *
 * @package    calendar-event-jquery
 * @subpackage calendar-event-jquery/inc
 * @author     Majeed Mohammadian <majeedmohammadian@gmail.com>
 */

class CEJ_Deactivate {
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
    }

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
    }

    /**
     * deactivate plugin
     *
     * @since    1.0.0
     */
	public function deactivate()
    {
		 /**
		  * You can add delete_option() or delete databases
		  */
	}
}
