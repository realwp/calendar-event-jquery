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
class CEJ_Page
{
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
        global $obj_page;

        unset($obj_page);
    }

    // Plugin option page operations
    public static function about()
    {
        echo cej_get_view('pages/about');
    }
}