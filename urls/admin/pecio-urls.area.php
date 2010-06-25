<?php 

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

// loading the plugin data
$plugin = PecPlugin::load('area_name', $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = 'Pecio URLs';
$area["permission_name"] = 'permission_plugins';
$area["head_data"] = '';
$area["messages"] = '';
$area["content"] = 'No view was executed.';


/* a function that does actions depending on what data is in the query string */

function do_actions() {
    global $plugin;
    $messages = '';

    return $messages;
}


/* creating functions for all the different views that will be available for this area */

function view_default() {  
    global $plugin, $pec_localization;

    $area_data = array();
    $area_data['title'] = 'Pecio URLs';
    $area_data['content'] = '
            With this plugin you can easily insert urls of pecio objects into your content.<br /><br />
            
            The variable for this plugin is ' . $plugin->get_property('variable') . '<br />
            In most cases you have to pass two arguments to the variable:
            <ol>
                <li>Object type, e.g. article</li>
                <li>ID of the object</li>
            </ol><br />
            
            <strong>Example:</strong> {%' . $plugin->get_property('variable') . '-(article,6)%}
            <br />
            
            But if you want to insert a url that doesn\'t need any IDs (e.g. the home url), you only have to pass the object type.<br />
            
            
            <h3 style="padding-left: 0px;">Possible object types:</h3>
            <ul>
                <li>home</li>
                <li>blog</li>
                <li>post</li>
                <li>category</li>
                <li>tag</li>
            </ul>
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
    $area['title'] .= ' (' . $pec_localization->get('LABEL_GENERAL_READONLY') . ')';
}

?>
