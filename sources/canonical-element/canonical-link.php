<?php

class CanonicalLinkPlugin extends PecAbstractPlugin {
    
    function __construct() {
        parent::__construct();
    }
    
    public function run($var_data='') {
        return '';
    }
    
    public function head_data() {
        $view_main =& $this->current_page['view']['main'];
        $view_sub =& $this->current_page['view']['sub'];
        
        if ($view_main == SITE_VIEW_HOME || $view_main == SITE_VIEW_HOME && $view_sub == SITE_VIEW_BLOG && $_GET['p'] == '1') {
            return '<link rel="canonical" href="' . create_home_url() . '" />';
        }
        elseif ($view_main == SITE_VIEW_BLOG && $_GET['p'] == '1') {
            return '<link rel="canonical" href="' . create_blog_url() . '" />';
        }
        elseif ($view_main = SITE_VIEW_BLOGCATEGORY && $_GET['p'] == '1') {
            $by = $this->settings->get_load_by();
            $category = PecBlogCategory::load($by, $_POST['category']);
            return '<link rel="canonical" href="' . create_blogcategory_url($category) . '" />';
        }
        elseif ($view_main = SITE_VIEW_BLOGTAG && $_GET['p'] == '1') {
            $by = $this->settings->get_load_by();
            $tag = PecBlogTag::load($by, $_POST['tag']);
            return '<link rel="canonical" href="' . create_blogtag_url($tag) . '" />';
        }
    }
    
}

?>
