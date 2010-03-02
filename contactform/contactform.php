<?php

class ContactformPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);

        require_once(PLUGIN_PATH . $this->plugin_meta->get_directory_name() . '/classes/contactform.class.php');

        $this->contactform_template = file_get_contents(PLUGIN_PATH . $this->plugin_meta->get_directory_name() . '/templates/contactform.tpl');
    }
    
    public function run($var_data='') {
        
        if (Contactform::exists('id', $var_data)) {
            $contactform = Contactform::load('id', $var_data);

            $contactform_html = str_replace(
                '{%AJAX_SEND_FILE_URL%}', 
                pec_root_path(false) . 'pec_plugins/' . $this->plugin_meta->get_directory_name() . '/send.ajax.php',
                $this->contactform_template
            );
            $contactform_html = str_replace('{%ID%}', $contactform->get_id(), $contactform_html);
            $contactform_html = str_replace('{%PLUGIN_DIRECTORY%}', $this->plugin_meta->get_directory_name(), $contactform_html);
        }
        else {
            $contactform_html = '';
        }
        
        return $contactform_html;    }
    
    public function head_data() {
        return '<script type="text/javascript" src="'. pec_root_path(false) . 'pec_plugins/' . $this->plugin_meta->get_directory_name() . '/js/ajax-send.js"></script>';
    }
    
}

?>
