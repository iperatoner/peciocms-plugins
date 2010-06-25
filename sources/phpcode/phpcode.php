<?php

class PHPCodeInclusionPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);

    }
    
    public function run($var_data='') {
        // This variable may be overridden by what's in the var data
        $output = '';
        
        eval($var_data);
        
        return $output;
    }
    
    public function head_data() {
        return '';
    }
    
}

?>
