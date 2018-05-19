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
class CEJ_Shortcode
{
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        add_shortcode('ceJQuery', array($this, 'add_short_code_ceJQuery'));
    }

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
        global $obj_shortCode;

        unset($obj_shortCode);
    }

    /**
     * Register the javascript for the admin area.
     *
     * @since    1.0.0
     *
     * @param      $attributes
     *
     * @return string
     */
    public function add_short_code_ceJQuery($attributes)
    {
        /*
         * type
         *
         * type = month          => show month type date picker
         * type = month_time     => show month type date time picker
         * */
        $type = null;
        $taxonomy = null;
        extract(shortcode_atts(array(
            "type" => 'month',
            "taxonomy" => null,
        ), $attributes));

        $date_year_e = cej_jdate('Y', '', '', 'Asia/Tehran', 'en');
        $date_month_e = cej_jdate('m', '', '', 'Asia/Tehran', 'en');

        $data = array();

        switch($type) {
            case 'month':
                wp_enqueue_script('cej-calender-jalali');
                wp_enqueue_style('cej-jquery-ui-smoothness');
                wp_enqueue_style('cej-calender-time-picker');

                $posts = array();
                
                $args = array(
                    'post_type' => strtolower('calendarEventJQuery'),
                    'meta_query' => array(
                        array(
                            'key'     => 'cej_date_to',
                            'value'   => $date_year_e . '-' . $date_month_e .'-',
                            'compare' => 'LIKE',
                        ),
                    ),
                );
                if($taxonomy) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'calendarEventJQuery_category',
                            'field'    => 'slug',
                            'terms'    => $taxonomy,
                        ),
                    );
                }

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
                $object_data = array(
                    'url' => admin_url('admin-ajax.php'),
                    'posts' => $posts,
                    'year' => intval($date_year_e),
                    'month' => intval($date_month_e),
                    'taxonomy' => $taxonomy
                );
                // Localize the script with new data
                wp_localize_script('cej-ceJQuery-month', 'object_date_picker', $object_data);
                wp_enqueue_script('cej-ceJQuery-month');
                wp_enqueue_style('cej-ceJQuery-month');

                return cej_get_view('shortCode/ceJQuery-month', $data);
                break;
            case 'month_time':
                return cej_get_view('shortCode/ceJQuery-month-time', $data);
                break;
        }
    }
}