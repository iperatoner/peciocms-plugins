<?php 

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = 'Canonical Link Element';
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
    $area_data['title'] = 'Canonical Link Element';

    $area_data['content'] = '
            This plugin adds the Canonical Link Element to the Head-Section of your website, 
            if the content of a site exists for more than one URL.<br /><br />

            It doesn\'t need a variable, because the Head-Data is automatically added by the CMS.
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
