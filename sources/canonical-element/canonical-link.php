<?php

class CanonicalLinkPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);
    }
    
    public function run($var_data='') {
        return '';    }
    
    public function head_data() {
        if ($this->site_view == SITE_VIEW_HOME || $this->site_view == SITE_VIEW_HOME && $this->sub_site_view == SITE_VIEW_BLOG && $_GET['p'] == '1') {
            return '<link rel="canonical" href="' . create_home_url() . '" />';
        }
        elseif ($this->site_view == SITE_VIEW_BLOG && $_GET['p'] == '1') {
            return '<link rel="canonical" href="' . create_blog_url() . '" />';
        }
        elseif ($this->site_view = SITE_VIEW_BLOGCATEGORY && $_GET['p'] == '1') {
            $by = $this->settings->get_load_by();
            $category = PecBlogCategory::load($by, $_POST['category']);
            return '<link rel="canonical" href="' . create_blogcategory_url($category) . '" />';
        }
        elseif ($this->site_view = SITE_VIEW_BLOGTAG && $_GET['p'] == '1') {
            $by = $this->settings->get_load_by();
            $tag = PecBlogTag::load($by, $_POST['tag']);
            return '<link rel="canonical" href="' . create_blogtag_url($tag) . '" />';
        }
    }
    
}

?>
