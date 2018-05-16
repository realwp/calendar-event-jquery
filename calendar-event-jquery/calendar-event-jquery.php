<?php
/**
 * calendar-event-jquery
 *
 * @author      Majeed Mohammadian
 * @copyright   2018 Green Web
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Calendar Event JQuery
 * Plugin URI:  https://wordpress.org/plugins/event-calendar-jquery/
 * Description: Event Calendar jquery and jquery ui
 * Version:     1.0.0
 * Author:      Majeed Mohammadian
 * Author URI:  https://majeed21.com
 * Text Domain: calendar-event-jquery
 * License:     Green Web
 * License URI: http://www.majeed21.com/licenses/
 * Network:     False
 */

// Limit Direct Access.
defined('ABSPATH') || exit('no access');

final class CEJ_Instance {
    private static $_instance = null;

    public static function getInstance() {
        if( self::$_instance === null ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        // Define Path Constants
        define('CEJ_PATH', trailingslashit(plugin_dir_path(__FILE__)));
        define('CEJ_URL', trailingslashit(plugin_dir_url(__FILE__)));
        define('CEJ_INCLUDE', trailingslashit(CEJ_PATH . 'includes'));
        define('CEJ_TPL', trailingslashit(CEJ_PATH . 'templates'));
        define('CEJ_CSS', trailingslashit(CEJ_URL . 'assets/css'));
        define('CEJ_JS', trailingslashit(CEJ_URL . 'assets/js'));
        define('CEJ_IMAGES', trailingslashit(CEJ_URL . 'assets' . '/' . 'img'));
        define('CEJ_ADMIN_CSS', trailingslashit(CEJ_URL . 'admin/assets/css'));
        define('CEJ_ADMIN_JS', trailingslashit(CEJ_URL . 'admin/assets/js'));

        // Define Setting Constants
        define('CEJ_NAME', 'calendar-event-jquery');
        define('CEJ_CAPTION', 'رویداد های تقویم');
        define('CEJ_CAPTION_AUTHOR', 'رویداد های تقویم جی کوئری نویسنده <a href="https://www.majeed21.com" target="_blank">مجید محمدیان</a>');
        define('CEJ_MENU_ICON', 'dashicons-calendar-alt');
        define('CEJ_VERSION', '1.0.0');

        // Define Dependency Plugin
        define('CEJ_DEPENDENCY', serialize(
            [
                [
                    'name'        => 'Majeed21 Essentials',
                    'version'     => '1.6.0',
                    'text-domain' => 'majeed21_essentials',
                    'link'        => 'javascript:void(0);',
                ],
            ]
        ));

        spl_autoload_register( array ( $this, '__autoload' ) );

        global $obj_ajax;
        global $obj_shortCode;
        global $obj_assets;
        global $obj_page;
        global $obj_menu;

        $obj_ajax = new CEJ_Ajax();
        $obj_shortCode = new CEJ_Shortcode();
        $obj_assets = new CEJ_Assets();
        $obj_page = new CEJ_Page();
        $obj_menu = new CEJ_Menu();

        if (is_admin()) {
            // Admin Operations
            global $obj_admin;

            $obj_admin = new CEJ_Admin();
        } else {
            // FrontEnd Operations
            global $obj_frontend;

            $obj_frontend = new CEJ_Frontend();
        }

        // Create Default Settings on Activate
        $obj_activator = new CEJ_Activator();
        register_activation_hook(__FILE__, array($obj_activator, 'activate'));

        // Remove and  disable settings & ...
        $obj_deactivate = new CEJ_Deactivate();
        register_deactivation_hook(__FILE__, array($obj_deactivate, 'deactivate'));

        global $obj_loader;

        $obj_loader = new CEJ_Loader();
    }

    /**
     * @param $class
     */
    public function __autoload($class)
    {
        if(is_dir(CEJ_INCLUDE)) {
            $files = array_diff(scandir(CEJ_INCLUDE), ['..', '.']);
            foreach($files as $file) {
                $position = strpos($file, "function-cej-before-");
                if($position === 0) {
                    if(file_exists(CEJ_INCLUDE . $file)) {
                        include_once(CEJ_INCLUDE . $file);
                    }
                }
            }
        }
        if(strpos($class, 'CEJ_') !== false) {
            $class_name = 'class-' . str_replace('_', '-', $class);
            $class_file_path = CEJ_INCLUDE . strtolower($class_name) . '.php';
            if(is_file($class_file_path) && file_exists($class_file_path)) {
                include_once($class_file_path);
            }
        }
        if(is_dir(CEJ_INCLUDE)) {
            $files = array_diff(scandir(CEJ_INCLUDE), ['..', '.']);
            foreach($files as $file) {
                $position = strpos($file, "function-cej-after-");
                if($position === 0) {
                    if(file_exists(CEJ_INCLUDE . $file)) {
                        include_once(CEJ_INCLUDE . $file);
                    }
                }
            }
        }
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }
}

CEJ_Instance::getInstance();