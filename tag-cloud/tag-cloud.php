<?php

class TagCloudPlugin extends PecAbstractPlugin {
    
    function __construct($plugin_meta, $site_view, $sub_site_view) {
        parent::__construct($plugin_meta, $site_view, $sub_site_view);

        $this->min_font_size = 7;
        $this->max_font_size = 28;

        $this->min_post_count = 1;

        $this->tresholds = 5;
    }

    private function get_tag_size_logarithmic($post_count, $max_post_count) { 
        $treshold = ($this->max_font_size - $this->min_font_size) / ($this->tresholds - 1);
        $a = $this->tresholds * log($post_count - $this->min_post_count + 2) / log($max_post_count - $this->min_post_count + 2) - 1; 
        return round($this->min_font_size + round($a) * $treshold); 
    }  

    private function get_tag_size_linear($post_count, $max_post_count, $tag_count) {
        if ($max_post_count != 0) {
            $font_size = round(1.4 * $this->max_font_size * ($post_count / ($max_post_count / 1.1)));
            $font_size = $font_size < $this->min_font_size ? $this->min_font_size : $font_size;
        }
        else {
            $font_size = $this->min_font_size;
        }
        return $font_size;
    }
    
    public function run($var_data='') {        
        $tags = PecBlogTag::load(false, false, "ORDER BY tag_name ASC");

        // checking wether blog is on start page or not
        $home = $this->settings->get_blog_onstart() ? true : false;

        $tag_cloud_html = '<div style="word-wrap: break-word;" class="pecio_tag_cloud">';

        // number of available tags
        $tag_count = count($tags);

        // maximum number of posts that are available
        $max_post_count = count(PecBlogPost::load(false, false, "WHERE post_status='1'"));

        foreach ($tags as $t) {
            // number of posts that have the current tag
            $post_count = count(PecBlogPost::load('tag', $t, "WHERE post_status='1'"));

            if ($var_data == 'log') {
                $font_size = $this->get_tag_size_logarithmic($post_count, $max_post_count);
            }
            elseif ($var_data == 'lin' || empty($var_data)) {
                $font_size = $this->get_tag_size_linear($post_count, $max_post_count, $tag_count);
            }
            else {
                $font_size = $this->get_tag_size_linear($post_count, $max_post_count, $tag_count);
            }

            $tag_cloud_html .= 
            '<a href="' . create_blogtag_url($t, false, $home) . '" style="font-size: ' . $font_size . 'pt;">' . $t->get_name() . '</a> ';
        }
        
        return $tag_cloud_html . '</div>';    }
    
    public function head_data() {
        return '';
    }
    
}

?>
