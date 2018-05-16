<?php
/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       http://majeed21.com
 * @since      1.0.0
 *
 * @package    calendar-event-jquery
 * @subpackage calendar-event-jquery/inc
 * @author     Majeed Mohammadian <majeedmohammadian@gmail.com>
 */
class CEJ_Activator {
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

    public function activate()
    {
        global $wpdb;

        add_action('admin_init', array($this, 'admin_init'));

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "";
        dbDelta($sql);
    }

    // Admin Init on Activate
    public function admin_init()
    {
        $role = get_role('administrator');

        $role->add_cap('cej_admin_cap');
        $role->add_cap('cej_admin_user');
    }
}