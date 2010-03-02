<?php 

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = 'PHP Code Inclusion Plugin';
$area["permission_name"] = 'permission_plugins';
$area["head_data"] = '';
$area["messages"] = '';
$area["content"] = 'No view was executed.';


/* a function that does actions depending on what data is in the query string */

function do_actions() {    
    $messages = '';
    
    return $messages;
}


/* creating functions for all the different views that will be available for this area */

function view_default() {  
    $area_data = array();
    $area_data['title'] = 'PHP Code Inclusion Plugin';

    $area_data['content'] = '
            With this plugin you can include PHP Code into your article, texts and blogposts.<br /><br />

            You just have to use the plugin variable {%PHPCODE-(put_php_code_here)%} and replace the "put_php_code_here" with your PHP Code.
    ';    
    
    return $area_data;
}


/* doing all the actions and then display the view given in the query string */

if ($pec_session->get('pec_user')->get_permission($area['permission_name']) > PERMISSION_READ) {
    $area['messages'] = do_actions();
}

switch ($_GET['view']) {        
    case 'default':
        $area_data = view_default();
        $area['title'] = $area_data['title'];
        $area['content'] = $area_data['content'];
        break;
        
    default:
        $area_data = view_default(); 
        $area['title'] = $area_data['title'];
        $area['content'] = $area_data['content'];
        break;
}

// append a "(Read-only)" if the user is only allowed to view the area
if ($pec_session->get('pec_user')->get_permission($area['permission_name']) < PERMISSION_FULL) {
    $area['title'] .= ' (Read-only)';
}

?>
