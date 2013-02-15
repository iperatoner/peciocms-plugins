<?php

class PecioUrlInsertionPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);
    }
    
    public function run($var_data='') {
        $params = explode(',', $var_data);

        $type = $params[0];
        $id = $params[1];

        switch ($type) {
            case 'home':
                $url = create_home_url();
                break;
                
            case 'article':
                $article = PecArticle::load('id', $id);
                $url = create_article_url($article);
                break;
                
            case 'post':
                $post = PecBlogPost::load('id', $id);
                $url = create_blogpost_url($post);
                break;
                
            case 'blog':
                $url = create_blog_url();
                break;
                
            case 'category':
                $cat = PecBlogCategory::load('id', $id);
                $url = create_blogcategory_url($cat);
                break;
                
            case 'tag':
                $tag = PecBlogTag::load('id', $id);
                $url = create_blogtag_url($tag);
                break;
        }
        
        return $url;
    }
    
    public function head_data() {
        return '';
    }
    
}

?>
