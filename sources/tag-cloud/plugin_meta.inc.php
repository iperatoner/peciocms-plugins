<?php 

$plugin_meta = array();

$plugin_meta["title"] = 'Tag Cloud';
$plugin_meta["description"] = 'A plugin that creates a tag cloud from all available blog tags.';

$plugin_meta["author"] = 'Immanuel Peratoner';
$plugin_meta["author_email"] = 'immanuel.peratoner@gmail.com';

$plugin_meta["year"] = '2009';
$plugin_meta["license"] = 'GNU GPLv3';

$plugin_meta["variable"] = 'BLOG_TAG_CLOUD';
$plugin_meta["input_enabled"] = true;

$plugin_meta["installation_required"] = false;

$plugin_meta["main_file"] = 'tag-cloud.php';

$plugin_meta["area_file"] = 'admin/tag-cloud.area.php';
$plugin_meta["area_name"] = 'tag-cloud';

$plugin_meta["class_name"] = 'TagCloudPlugin';

?>
