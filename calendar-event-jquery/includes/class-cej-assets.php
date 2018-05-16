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
class CEJ_Assets
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
        global $obj_assets;

        unset($obj_assets);
    }

    /**
     * Register the javascript for the admin area.
     *
     * @since    1.0.0
     */
    public function admin_scripts()
    {
        wp_register_script('cej-admin', strtolower(CEJ_URL . 'assets/js/admin/script.js'), array('jquery'), CEJ_VERSION, FALSE);
        wp_register_script('cej-jquery-tiptip', strtolower(CEJ_URL . '/assets/js/jquery-tiptip/jquery.tipTip.js'), array('jquery'), CEJ_VERSION, true);
        wp_register_script('cej-meta-boxes', strtolower(CEJ_URL . '/assets/js/admin/meta-boxes.js'), array('jquery', 'jquery-ui-datepicker', 'cej-jquery-tiptip'), CEJ_VERSION);
        wp_register_script('cej-calender-jalali', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jalaliCalendar.js'), array('jquery', 'jquery-ui-datepicker'), CEJ_VERSION);
        wp_register_script('cej-calender-time-picker-before', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon.js'), array('jquery', 'jquery-ui-datepicker'), CEJ_VERSION);
        wp_register_script('cej-calender-time-picker', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon-i18n.js'), array('cej-calender-time-picker-before'), CEJ_VERSION);

        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        if(is_admin() && ($action == 'edit' || get_current_screen()->action == 'add')) {
            wp_enqueue_script('cej-calender-jalali');
            wp_enqueue_script('cej-calender-time-picker');
            wp_enqueue_script('cej-meta-boxes');
        }

        wp_enqueue_script('cej-admin');
    }

    /**
     * Register the stylesheets for the admin area.0
     *
     * @since    1.0.0
     */
    public function admin_styles()
    {
        wp_register_style('cej-admin', strtolower(CEJ_URL . 'assets/css/admin/style.css'), array(), CEJ_VERSION, 'all');
        wp_register_style('cej-admin-rtl', strtolower(CEJ_URL . 'assets/css/admin/style-rtl.css'), array(), CEJ_VERSION, 'all');

        wp_register_style('cej-admin-meta-box', strtolower(CEJ_URL . 'assets/css/admin/meta-box.css'), array(), CEJ_VERSION, 'all');
        wp_register_style('cej-admin-meta-box-rtl', strtolower(CEJ_URL . 'assets/css/admin/meta-box-rtl.css'), array(), CEJ_VERSION, 'all');

        wp_register_style('cej-jquery-ui-smoothness', strtolower(CEJ_URL . '/assets/css/jquery-ui/smoothness/jquery-ui.css'), array(), CEJ_VERSION, 'all');
        wp_register_style('cej-calender-time-picker', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon.css'), array(), CEJ_VERSION, 'all');

        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        if(is_admin()) {
            if(is_rtl()) {
                wp_enqueue_style('cej-admin-rtl');
            } else {
                wp_enqueue_style('cej-admin');
            }
            if($action == 'edit' || get_current_screen()->action == 'add') {
                wp_enqueue_style('cej-jquery-ui-smoothness');
                wp_enqueue_style('cej-calender-time-picker');
                if(is_rtl()) {
                    wp_enqueue_style('cej-admin-meta-box-rtl');
                } else {
                    wp_enqueue_style('cej-admin-meta-box');
                }
            }
        }
    }

    /**
     * Register the javascript for the frontend area.
     *
     * @since    1.0.0
     */
    public function frontend_scripts()
    {
        wp_register_script('cej-frontend', strtolower(CEJ_URL . '/assets/js/script.js'), array( 'jquery' ), CEJ_VERSION );
        wp_register_script('cej-calender-jalali', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jalaliCalendar.js'), array('jquery', 'jquery-ui-datepicker'), CEJ_VERSION);
        wp_register_script('cej-calender-time-picker-before', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon.js'), array('jquery', 'jquery-ui-datepicker'), CEJ_VERSION);
        wp_register_script('cej-calender-time-picker', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon-i18n.js'), array('cej-calender-time-picker-before'), CEJ_VERSION);
        wp_register_script('cej-ceJQuery-month', strtolower(CEJ_URL . '/assets/js/shortcode/ceJQuery-month.js'), array('jquery', 'jquery-ui-datepicker'), CEJ_VERSION);

        wp_enqueue_script('cej-frontend');
    }

    /**
     * Register the stylesheets for the frontend area.
     *
     * @since    1.0.0
     */
    public function frontend_styles()
    {
        wp_enqueue_style('cej-frontend', strtolower(CEJ_URL . 'assets/css/style.css'), array(), CEJ_VERSION, 'all');
        wp_register_style('cej-jquery-ui-smoothness', strtolower(CEJ_URL . '/assets/css/jquery-ui/smoothness/jquery-ui.css'), array(), CEJ_VERSION, 'all');
        wp_register_style('cej-calender-time-picker', strtolower(CEJ_URL . '/assets/js/dateTimePicker/jquery-ui-timepicker-addon.css'), array(), CEJ_VERSION, 'all');
        wp_enqueue_style('cej-ceJQuery-month', strtolower(CEJ_URL . 'assets/css/shortcode/ceJQuery-month.css'), array(), CEJ_VERSION, 'all');

        wp_enqueue_style('cej-frontend');
    }
}