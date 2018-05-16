<?php
if(!function_exists('cej_get_view')) {
    function cej_get_view($file, $data = array()) {
        if($file == '') {
            trigger_error( 'Error: not selection template' );
            exit;
        } else {
            $file = CEJ_TPL . $file . '.tpl';

            if (file_exists($file)) {
                extract($data);
                ob_start();
                require_once($file);
                $output = ob_get_contents();
                ob_end_clean();
                return $output;
            } else {
                trigger_error('Error: Could not load template ' . $file . '!');
                exit;
            }
        }
    }
}