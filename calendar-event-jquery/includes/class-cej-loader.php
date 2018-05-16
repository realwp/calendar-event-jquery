<?php
/**
 * Fired during plugin loading.
 *
 * This class defines all code necessary in init and plugins_loaded add_actions
 *
 * @link       http://majeed21.com
 * @since      1.0.0
 *
 * @package    calendar-event-jquery
 * @subpackage calendar-event-jquery/inc
 * @author     Majeed Mohammadian <majeedmohammadian@gmail.com>
 */
class CEJ_Loader
{
	public static $add_meta_boxes;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
	public function __construct()
    {
        // init function
        add_action('init', array($this, 'init'));

		// add text domain language
		add_action('plugins_loaded', array($this, 'load_text_domain'));

		// add post type
		add_action('init', array($this, 'add_post_type'));

		// add meta boxes in post type
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));

		// save meta boxes in post type
        add_action('save_post', array($this, 'save_post_meta'));

        // set custom field meta boxes
        $this->set_meta_box();
	}

    /**
     * destructor the class
     *
     * @since    1.0.0
     */
    public function __destruct()
    {
        global $obj_loader;

        unset($obj_loader);
    }

	public function init()
    {
        add_filter('admin_footer_text', function($text){
            global $post;
            if($post->post_type == strtolower('calendarEventJQuery')) {
                echo '<span id="footer-thankyou">' . CEJ_CAPTION_AUTHOR . '</span>';
            } else {
                echo $text;
            }
        });
    }

	public function load_text_domain()
    {
		load_plugin_textdomain( CEJ_NAME, false, CEJ_NAME . '/language' );
	}

    public function add_post_type()
    {
        register_post_type('calendarEventJQuery', array(
                'labels'              => array(
                    'name'               => _x('رویداد های تقویم', 'post type general name'),
                    'singular_name'      => _x('رویداد های تقویم', 'post type singular name'),
                    'add_new'            => _x('افزودن رویداد جدید', 'لیست مسابقات عکاسی'),
                    'add_new_item'       => __('افزودن رویداد جدید'),
                    'edit_item'          => __('ویرایش رویداد'),
                    'new_item'           => __('جدید'),
                    'all_items'          => __('همه رویداد ها'),
                    'view_item'          => __('نمایش رویداد'),
                    'search_items'       => __('جست و جوی رویداد'),
                    'not_found'          => __('رویدادی یافت نشد'),
                    'not_found_in_trash' => __('رویدادی در زباله دان یافت نشد'),
                    'parent_item_colon'  => __('نام رویداد'),
                    'menu_name'          => __('رویداد های تقویم')
                ),
                'description'         => __('ذخیره اطلاعات'),
                'menu_icon'           => 'dashicons-calendar-alt',
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => false,
                'menu_position'       => 100,
                'show_in_nav_menus'   => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => false,
                'has_archive'         => false,
                'query_var'           => true,
                'can_export'          => false,
                'rewrite'             => array('slug' => 'calendar-event'),
                '_builtin'            => false,
                'capability_type'     => 'post',
                'hierarchical'        => false,
                'supports'            => array(
                    'title',
                    'editor',
                    'thumbnail'
                )
            )
        );

        register_taxonomy('calendarEventJQuery_category', strtolower('calendarEventJQuery'),
            array(
                'labels' => array(
                    'name'              => _x('دسته بندی رویداد', 'taxonomy general name'),
                    'singular_name'     => _x('دسته بندی رویداد', 'taxonomy singular name'),
                    'search_items'      => __('جست و جو'),
                    'all_items'         => __('همه دسته بندی ها'),
                    'parent_item'       => __('دسته والد'),
                    'parent_item_colon' => __('دسته والد:'),
                    'edit_item'         => __('ویرایش'),
                    'update_item'       => __('تغییر'),
                    'add_new_item'      => __('افزودن دسته بندی رویداد جدید'),
                    'new_item_name'     => __('دسته بندی جدید'),
                    'menu_name'         => __('دسته بندی رویداد'),
                ),
                'hierarchical' => true,
            )
        );
    }

    private function set_meta_box()
    {
        CEJ_Loader::$add_meta_boxes = [
            [
                'id' => 'meta_boxes_parameters',
                'title' => _('پارامتر ها'),
                'post-type' => strtolower('calendarEventJQuery'),
                'groups' => [
                    [
                        'id' => 'meta_boxes_parameters_group_date',
                        'name' => 'زمان رویداد',
                        'icon' => 'dashicons-calendar-alt',
                        'fields' => [
                            [
                                'type' => 'date',
                                'name' => 'cej_date_from',
                                'title' => 'از تاریخ',
                                'description' => '',
                                'placeholder' => 'از تاریخ',
                                'default' => null
                            ],
                            [
                                'type' => 'date',
                                'name' => 'cej_date_to',
                                'title' => 'تا تاریخ',
                                'description' => '',
                                'placeholder' => 'تا تاریخ',
                                'default' => null
                            ],
                        ]
                    ],
                    [
                        'id' => 'meta_boxes_parameters_group_setting',
                        'name' => 'تنظیمات دیگر',
                        'icon' => 'dashicons-admin-generic',
                        'fields' => [
                            [
                                'type' => 'input',
                                'name' => 'cej_class',
                                'title' => 'کلاس css',
                                'description' => 'کلاس css را وارد نمایید',
                                'placeholder' => '',
                                'default' => null
                            ],
                        ]
                    ],
                ]
            ],
        ];
    }

    public function add_meta_boxes()
    {
        wp_enqueue_script('cej-meta-boxes');
        $add_meta_boxes = CEJ_Loader::$add_meta_boxes;
        foreach($add_meta_boxes as $index => $add_meta_box) {
            add_meta_box($add_meta_box['id'], $add_meta_box['title'], array($this, 'render_template_meta_boxes'), $add_meta_box['post-type'], 'advanced', 'default', $add_meta_box);
        }
    }

    public function render_template_meta_boxes($post, $meta_box)
    {
        $theme = '<div class="meta-boxes-parameters-data">';
        $theme .= wp_nonce_field('calendar-event-jquery', 'calendar_event_jquery_nonce', true, false);
        $theme .= '<div class="panel-wrap"><ul class="cej-tabs">';
        foreach($meta_box['args']['groups'] as $index => $group) {
            if(!$index) {
                $theme .= '<li class="active"><a href="#'.$group['id'].'"><i class="dashicons-before '.$group['icon'].'"></i><span>'.$group['name'].'</span></a></li>';
            } else {
                $theme .= '<li><a href="#'.$group['id'].'"><i class="dashicons-before '.$group['icon'].'"></i><span>'.$group['name'].'</span></a></li>';
            }
        }
        $theme .= '</ul>';
        foreach($meta_box['args']['groups'] as $index => $group) {
            if(!$index) {
                $theme .= '<div id="'.$group['id'].'" class="panel options-panel" style="display: block;">';
            } else {
                $theme .= '<div id="'.$group['id'].'" class="panel options-panel" style="display: none;">';
            }
            foreach($group['fields'] as $j => $field) {
                $default = (isset($field['default'])) ? $field['default'] : null;
                $post_meta_value = get_post_meta($post->ID, $field['name'], true);
                $value = ($post_meta_value) ? $post_meta_value : $default;
                $theme .= '<p class="form-field">';
                switch($field['type']) {
                    case 'input':
                        $theme .= '<label for="'.$field['name'].'">'.$field['title'].'</label>
                                   <input type="text" class="short cej_input" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'">';
                        if(isset($field['description']) && $field['description'] != '') {
                            $theme .= '<span class="help-tip">' . $field['description'] . '</span>';
                        }
                        break;
                    case 'number':
                        $theme .= '<label for="'.$field['name'].'">'.$field['title'].'</label>
                                   <input type="number" class="short cej_input" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'">';
                        if(isset($field['description']) && $field['description'] != '') {
                            $theme .= '<span class="help-tip">' . $field['description'] . '</span>';
                        }
                        break;
                    case 'date':
                        $theme .= '<label for="'.$field['name'].'">'.$field['title'].'</label>
                                   <input type="text" class="short cej_input date-picker" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$value.'" placeholder="'.$field['placeholder'].'">';
                        if(isset($field['description']) && $field['description'] != '') {
                            $theme .= '<span class="help-tip">' . $field['description'] . '</span>';
                        }
                        break;
                    case 'select':
                        $theme .= '<label for="'.$field['name'].'">'.$field['title'].'</label>
                                   <select id="'.$field['name'].'" name="'.$field['name'].'" class="select short">';
                        foreach($field['options'] as $option) {
                            $selected = ($option['value'] == $value) ? ' selected' : '';
                            $theme .= '<option value="'.$option['value'].'"'.$selected.'>'.$option['text'].'</option>';
                        }
                        $theme .= '</select>';
                        if(isset($field['description']) && $field['description'] != '') {
                            $theme .= '<span class="help-tip">' . $field['description'] . '</span>';
                        }
                        break;
                    case 'radio':
                        $theme .= '<label for="'.$field['name'].'">'.$field['title'].'</label>';
                        foreach($field['options'] as $option) {
                            $selected = ($option['value'] == $value) ? ' checked' : '';
                            $theme .= '<span style="display: block">
                                            <input type="radio" class="radio" name="'.$field['name'].'" id="'.$field['name'].'-'.$option['value'].'" value="'.$option['value'].'"'.$selected.'>
                                            <span class="description">'.$option['text'].'</span>
                                       </span>';
                        }
                        break;
                }
                $theme .= '</p>';
            }
            $theme .= '</div>';
        }
        $theme .= '<div class="clear"></div></div></div>';

        echo $theme;
    }

    public function save_post_meta($post_id)
    {
        $nonce = (isset($_POST['calendar_event_jquery_nonce'])) ? $_POST['calendar_event_jquery_nonce'] : null;
        $_nonce = wp_verify_nonce($nonce, 'calendar-event-jquery');
        if($_nonce) {
            $add_meta_boxes = CEJ_Loader::$add_meta_boxes;
            $parameters = [];
            foreach($add_meta_boxes as $index => $add_meta_box) {
                $parameters[$index]['post-type'] = $add_meta_box['post-type'];
                foreach($add_meta_box['groups'] as $group) {
                    foreach($group['fields'] as $field) {
                        $parameters[$index]['fields'][] = $field['name'];
                    }
                }
            }
            $post_type = get_post_type($post_id);
            foreach($parameters as $index => $parameter) {
                if(strtolower($parameter['post-type']) == strtolower($post_type)) {
                    foreach($parameter['fields'] as $field) {
                        $value = (isset($_POST[$field])) ? $_POST[$field] : null;
                        if($value) {
                            update_post_meta($post_id, $field, $value);
                        }
                    }
                }
            }
        }
    }
}
