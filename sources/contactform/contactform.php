<?php

class ContactformPlugin extends PecAbstractPlugin {
    
    function __construct() {
        parent::__construct();
    }
    
    public function run($var_data='') {
    
        require_once($this->plugin_meta->get_directory_path() . 'classes/contactform.class.php');
        
        if (Contactform::exists('id', $var_data)) {

            $this->contactform_template = file_get_contents($this->plugin_meta->get_directory_path() . 'templates/contactform.tpl');
        
            $contactform = Contactform::load('id', $var_data);

            $contactform_html = str_replace(
                '{%AJAX_SEND_FILE_URL%}', 
                $this->plugin_meta->get_directory_path(false) . 'send.ajax.php',
                $this->contactform_template
            );
            $contactform_html = str_replace('{%ID%}', $contactform->get_id(), $contactform_html);
            $contactform_html = str_replace('{%PLUGIN_DIRECTORY%}', $this->plugin_meta->get_directory_name(), $contactform_html);
            
            // Replace locale strings
            $contactform_html = str_replace('{%CF_NAME%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_NAME'), $contactform_html);
            $contactform_html = str_replace('{%CF_EMAIL%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_EMAIL'), $contactform_html);
            $contactform_html = str_replace('{%CF_SUBJ%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_SUBJ'), $contactform_html);
            $contactform_html = str_replace('{%CF_MSG%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_MSG'), $contactform_html);
            $contactform_html = str_replace('{%CF_SEND%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_SEND'), $contactform_html);
            $contactform_html = str_replace('{%CF_MUST_ENABLE_JS%}', $this->localization->get('PLUGIN_CONTACTFORM_CF_MUST_ENABLE_JS'), $contactform_html);
        }
        else {
            $contactform_html = '';
        }
        
        return $contactform_html;
    }
    
    public function head_data() {
        return '<script type="text/javascript" src="'. $this->plugin_meta->get_directory_path(false) . '/js/ajax-send.js"></script>';
    }
    
}

?>
