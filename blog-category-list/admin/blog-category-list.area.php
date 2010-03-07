<?php 

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

// loading the plugin data
$plugin = PecPlugin::load('area_name', $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = 'Blog Category List';
$area["permission_name"] = 'permission_plugins';
$area["head_data"] = '';
$area["messages"] = '';
$area["content"] = 'No view was executed.';


/* a function that does actions depending on what data is in the query string */

function do_actions() {
    global $plugin;
    $messages = '';

    if (isset($_GET['action']) && !empty($_GET['action'])) {
        if ($_GET['action'] == 'save-templates') {
            if (isset($_POST['list_wrapper_template']) && isset($_POST['list_element_template'])) {
                if (@file_put_contents(
                        PLUGIN_PATH . $plugin->get_directory_name() . '/templates/list-wrapper.tpl', 
                        stripslashes($_POST['list_wrapper_template'])) &&         
                    @file_put_contents(
                        PLUGIN_PATH . $plugin->get_directory_name() . '/templates/list-element.tpl', 
                        stripslashes($_POST['list_element_template']))) {

                    $messages .= PecMessageHandler::custom(
                        'Saved templates', 
                        'You have successfully saved the blog category list templates.',
                        MESSAGE_INFO
                    );
                }
                else {
                    $messages .= PecMessageHandler::custom(
                        'Could not save templates', 
                        'The templates could not be saved. Perhaps the web server does not have the permission to change the template files.
                         Please check and try again.',
                        MESSAGE_WARNING
                    );
                }
            }
        }
    }    

    return $messages;
}


/* creating functions for all the different views that will be available for this area */

function view_default() {  
    global $plugin, $pec_localization;

    $area_data = array();
    $area_data['title'] = 'Blog Category List';
    $area_data['content'] = '
            With this plugin you can list all your blog categories anywhere on the website.<br /><br />

            The variable for this plugin is {%' . $plugin->get_property('variable') . '%}<br /><br>
            
            <form method="post" action="' . AREA . '&amp;action=save-templates">
                <h3 style="padding-left: 0px;">Edit List wrapper template</h3>
                Below you can edit the template for the list wrapper. 
                Remember that the web server needs the permission to change the file 
                "pec_plugins/' . $plugin->get_directory_name() . '/templates/list-wrapper.tpl".<br /><br />

                <textarea name="list_wrapper_template" style="width: 500px; height: 100px;">' . file_get_contents(PLUGIN_PATH . $plugin->get_directory_name() . '/templates/list-wrapper.tpl') . '</textarea>
                <br /><br />
                
                <h3 style="padding-left: 0px;">Edit List element template</h3>
                Below you can edit the template for a list element. 
                Remember that the web server needs the permission to change the file 
                "pec_plugins/' . $plugin->get_directory_name() . '/templates/list-element.tpl".<br /><br />

                <textarea name="list_element_template" style="width: 500px; height: 100px;">' . file_get_contents(PLUGIN_PATH . $plugin->get_directory_name() . '/templates/list-element.tpl') . '</textarea>
                <br /><br />
                
                <input type="submit" value="' . $pec_localization->get('BUTTON_SAVE') . '" />
            </form>
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
