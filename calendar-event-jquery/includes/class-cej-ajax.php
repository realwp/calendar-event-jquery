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
class CEJ_Ajax
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        // add ajax public
        add_action('wp_ajax_cej_ajax_public', array($this, 'ajax_public'));
        add_action('wp_ajax_nopriv_cej_ajax_public', array($this, 'ajax_public'));

        // add ajax login current user
        add_action('wp_ajax_cej_ajax', array($this, 'ajax_login'));

        // add ajax not login current user
        add_action('wp_ajax_nopriv_cej_ajax', array($this, 'ajax_not_login'));
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

    /**
     * add ajax public
     */
    public function ajax_public()
    {
        $year = (isset($_POST['year'])) ? $_POST['year'] : null;
        $month = (isset($_POST['month'])) ? $_POST['month'] : null;

        $json['ok'] = false;
        if($year) {
            if($month) {
                $posts = array();

                $args = array(
                    'post_type' => strtolower('calendarEventJQuery'),
                    'meta_query' => array(
                        array(
                            'key'     => 'cej_date_to',
                            'value'   => $year . '-' . $month .'-',
                            'compare' => 'LIKE',
                        ),
                    ),
                );

                $query = new WP_Query($args);

                foreach($query->posts as $index => $post) {
                    $posts[] = array(
                        'id' => $post->ID,
                        'link' => get_the_permalink($post->ID),
                        'title' => $post->post_title,
                        'content' => $post->post_content,
                        'date_from' => get_post_meta($post->ID, 'cej_date_from', true),
                        'date_to' => get_post_meta($post->ID, 'cej_date_to', true),
                        'ranges' => cej_date_range_jalali(get_post_meta($post->ID, 'cej_date_from', true), get_post_meta($post->ID, 'cej_date_to', true))
                    );
                }
                if($posts) {
                    $json['ok'] = true;
                    $json['posts'] = $data['posts'] = $posts;
                    $json['theme'] = cej_get_view('shortCode/ceJQuery-month-ajax', $data);;
                } else {
                    $json['error'] = 'داده ای یافت نشده است';
                }
            } else {
                $json['error'] = 'ماه ارسال نشده است';
            }
        } else {
            $json['error'] = 'سال ارسال نشده است';
        }
        
        wp_send_json($json);
    }

    /**
     * add ajax login current user
     */
    public function ajax_login()
    {

    }

    /**
     * add ajax not login current user
     */
    public function ajax_not_login()
    {

    }
}