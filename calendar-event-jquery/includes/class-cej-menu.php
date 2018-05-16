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

class CEJ_Menu
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        // add admin menu
        add_action('admin_menu', array($this, 'add_admin_menus'));
    }

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
        global $obj_menu;

        unset($obj_menu);
    }

    /**
     * add menu for the admin area.
     *
     * @since    1.0.0
     */
    public function add_admin_menus()
    {
        global $obj_page, $submenu;

        add_menu_page($this->plugin_name, CEJ_CAPTION, 'activate_plugins', 'cej_about', array($obj_page, 'about'), CEJ_MENU_ICON, 100);

        $submenu['cej_about'][] = [__('همه رویداد ها'), 'activate_plugins', get_admin_url() . 'edit.php?post_type=calendareventjquery', 'calendar-event-jquery'];
        $submenu['cej_about'][] = [__('افزودن رویداد جدید'), 'activate_plugins', get_admin_url() . 'post-new.php?post_type=calendareventjquery', 'calendar-event-jquery'];

        add_submenu_page('cej_about', $this->plugin_name, __('درباره پلاگین', ''), 'activate_plugins', 'cej_about', array($obj_page, 'about'));
    }
}