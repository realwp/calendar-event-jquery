<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://majeed21.com
 * @since      1.0.0
 *
 * @package    calendar-event-jquery
 * @subpackage calendar-event-jquery/inc
 * @author     Majeed Mohammadian <majeedmohammadian@gmail.com>
 */
class CEJ_Admin
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        global $obj_assets;

        // add script admin
        add_action('admin_enqueue_scripts', array($obj_assets, 'admin_scripts'));

        // add style admin
        add_action('admin_enqueue_scripts', array($obj_assets, 'admin_styles'));
    }

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
        global $obj_admin;

        unset($obj_admin);
    }
}