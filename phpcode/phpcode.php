<?php

class PHPCodeInclusionPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);

    }
    
    public function run($var_data='') {
        eval($var_data);
        
        return '';    }
    
    public function head_data() {
        return '';
    }
    
}

?>
