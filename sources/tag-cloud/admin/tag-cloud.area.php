<?php 

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

// loading the plugin data
$plugin = PecPlugin::load('area_name', $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = 'Tag Cloud';
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
    global $plugin, $pec_localization;

    $area_data = array();
    $area_data['title'] = 'Tag Cloud';
    $area_data['content'] = '
            With this plugin you can create a cloud of all you blog tags.<br /><br />

            The variable for this plugin is {%' . $plugin->get_property('variable') . '-(ID)%}<br /><br>

            There are two different types of calculation you can use. You have to give the id of the calculation type to the variable.<br /><br />

            <table class="data_table" cellspacing="0">
                <thead>
                    <tr class="head_row">
                        <th class="short_column">ID</th>
                        <th class="long_column">Calculation type</th>
                        <th class="medium_column">Example</th>
                    <tr>
                </thead>
                <tbody>
                    <tr class="data_row">
                        <td class="normal_column ">
                            lin
                        </td>
                        <td class="normal_column ">
                            Linear Algorithm
                        </td>
                        <td class="normal_column ">
                             {%' . $plugin->get_property('variable') . '-(lin)%}
                        </td>
                    </tr>
                    <tr class="data_row">
                        <td class="normal_column ">
                            log
                        </td>
                        <td class="normal_column ">
                            Logarithmic Algorithm
                        </td>
                        <td class="normal_column ">
                             {%' . $plugin->get_property('variable') . '-(log)%}
                        </td>
                    </tr>
                </tbody>
            </table>
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
