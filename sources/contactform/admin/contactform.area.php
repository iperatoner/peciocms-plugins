<?php 

// loading the plugin data
$plugin = PecPlugin::load('area_name', $_GET[ADMIN_AREA_VAR]);

// loading additional files
require(PLUGIN_PATH . $plugin->get_directory_name() . '/classes/contactform.class.php');

define('AREA', ADMIN_MAIN_FILE . '?t=plugin&amp;' . ADMIN_AREA_VAR . '=' . $_GET[ADMIN_AREA_VAR]);

/* main area data */
$area = array();
$area["title"] = $pec_localization->get('PLUGIN_CONTACTFORM_CONTACTFORMS');
$area["permission_name"] = 'permission_plugins';
$area["head_data"] = '';
$area["messages"] = '';
$area["content"] = 'No view was executed.';


/* a function that does actions depending on what data is in the query string */

function do_actions() {
    global $pec_localization;
    
    $messages = '';
    
    // costum message
    if (isset($_GET['message']) && !empty($_GET['message']) && 
        isset($_GET['message_data']) && !empty($_GET['message_data']) && 
        PecMessageHandler::exists($_GET['message'])) {  
                    
        $messages .= PecMessageHandler::get($_GET['message'], array(
            '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
            '{%NAME%}' => $_GET['message_data'],
            '{%ID%}' => $_GET['message_data']
        ));
        
    }
        
    if (isset($_GET['action'])) {
        // CREATE
        if ($_GET['action'] == 'create' && isset($_POST['contactform_email'])) {
                
            $contactform = new Contactform(NULL_ID, $_POST['contactform_email']);
            $contactform->save();
            
            $messages .= PecMessageHandler::get('content_created', array(
                '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
                '{%NAME%}' => $contactform->get_email()
            ));
        }
        
        // SAVE
        elseif ($_GET['action'] == 'save' && isset($_POST['contactform_email'])) {
                
            if (isset($_GET['id']) && Contactform::exists('id', $_GET['id'])) {
                
                $contactform = Contactform::load('id', $_GET['id']);
                $contactform->set_email($_POST['contactform_email']);
                $contactform->save();
                
                $messages .= PecMessageHandler::get('content_edited', array(
                    '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
                    '{%NAME%}' => $contactform->get_email()
                ));
            }
            else {
                $messages .= PecMessageHandler::get('content_not_found_id', array(
                    '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
                    '{%ID%}' => ''
                ));
            }
        }
        
        // REMOVE
        elseif ($_GET['action'] == 'remove' && isset($_GET['id'])) {
            if (Contactform::exists('id', $_GET['id'])) {
                $contactform = Contactform::load('id', $_GET['id']);
                $contactform_email = $contactform->get_email();
                $contactform->remove();
                
                $messages .= PecMessageHandler::get('content_removed', array(
                    '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
                    '{%NAME%}' => $contactform_email
                ));
            }
            else {                
                $messages .= PecMessageHandler::get('content_not_found_id', array(
                    '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM'),
                    '{%ID%}' => $_GET['id']
                ));
            }
        }
        
        // DEFAULT ACTIONS (REMOVE MULTIPLE, SORT)
        elseif ($_GET['action'] == 'default_view_actions') {
        
            // REMOVE MULTIPLE
            if (isset($_POST['remove_contactforms'])) {
                if (!empty($_POST['remove_box'])) {
                    
                    foreach ($_POST['remove_box'] as $contactform_id) {
                        $contactform = Contactform::load('id', $contactform_id);
                        $contactform->remove();
                    }
                              
                    $messages .= PecMessageHandler::get('content_removed_multiple', array(
                        '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM_CONTACTFORMS'),
                        '{%NAME%}' => ''
                    ));
                }
                else {
                    $messages .= PecMessageHandler::get('content_not_selected', array(
                        '{%CONTENT_TYPE%}' => $pec_localization->get('PLUGIN_CONTACTFORM_CONTACTFORMS'),
                        '{%NAME%}' => ''
                    ));
                }
            }
        }
        
    }
    
    return $messages;
}


/* creating functions for all the different views that will be available for this area */

function view_edit() {
    global $pec_localization;
    
    $area_data = array();    
    $area_data['title'] = $pec_localization->get('PLUGIN_CONTACTFORM_CONTACTFORMS');
    
    if (isset($_GET['id'])) {
        if (Contactform::exists('id', $_GET['id'])) {
            $contactform = Contactform::load('id', $_GET['id']);
            $area_data['title'] .= ' &raquo; ' . $pec_localization->get('PLUGIN_CONTACTFORM_EDIT') . ' &raquo; ' . $contactform->get_email();
            
            $action = 'save';
            $id_query_var = '&amp;id=' . $_GET['id'];
        }
        else {
            pec_redirect('pec_admin/' . AREA . '&message=content_not_found_id&message_data=' . $_GET['id']);
        }
    }
    else {
        // create an empty contactform
        $contactform = new Contactform(NULL_ID, '');
        $area_data['title'] .= ' &raquo; ' . $pec_localization->get('PLUGIN_CONTACTFORM_CREATE');
        
        $action = 'create';
        $id_query_var = '';
    }    
    
    $area_data['content'] = '
        <form method="post" action="' . AREA . '&amp;view=default&amp;action=' . $action . $id_query_var . '" id="contactforms_edit_form" />
            <h3>' . $pec_localization->get('PLUGIN_CONTACTFORM_EMAIL') . ':</h3>
            <input type="text" size="75" name="contactform_email" id="contactform_email" value="' . $contactform->get_email() . '" />
            <br /><br />
            
            <input type="submit" value="' . $pec_localization->get('BUTTON_SAVE') . '"/> 
            <a href="' . AREA . '"><input type="button" onclick="location.href=\'' . AREA . '\'" value="' . $pec_localization->get('BUTTON_CANCEL') . '" /></a>
        </form>            
    ';
    
    return $area_data;
}

function view_default() {
    global $pec_localization, $plugin;
  
    $area_data = array();
    $area_data['title'] = $pec_localization->get('PLUGIN_CONTACTFORM_CONTACTFORMS');

    $contactforms = Contactform::load();

    $area_data['content'] = '
        <form method="post" action="' . AREA . '&amp;view=default&amp;action=default_view_actions" id="contactforms_main_form" onsubmit="return confirm(\'' . $pec_localization->get('PLUGIN_CONTACTFORM_REALLY_REMOVE_SELECTED') . '\');" />
            <input type="button" value="' . $pec_localization->get('PLUGIN_CONTACTFORM_CREATE_NEW') . '" onclick="location.href=\'' . AREA . '&amp;view=edit\'"/>
            <input type="submit" name="remove_contactforms" value="' . $pec_localization->get('BUTTON_REMOVE') . '" /><br /><br />


            ' . str_replace(
                    '{%PLUGIN_VARIABLE%}' , 
                    '{%' . $plugin->get_property('variable'). '-(ID)%}', 
                    $pec_localization->get('PLUGIN_CONTACTFORM_VARIABLE_HINT')
                ) . '

            <br /><br /><br />
      

            <table class="data_table" cellspacing="0">
                <thead>
                    <tr class="head_row">
                        <th class="check_column"><input type="checkbox" onclick="checkbox_mark_all(\'remove_box\', \'contactforms_main_form\', this);" /></th>
                        <th class="long_column">' . $pec_localization->get('PLUGIN_CONTACTFORM_EMAIL') . '</th>
                        <th class="short_column">ID</th>
                    <tr>
                </thead>
                <tbody>
    ';
    
    foreach ($contactforms as $cf) {
        $area_data['content'] .= '
                    <tr class="data_row" title="#' . $cf->get_id() . '">
                        <td class="check_column"><input type="checkbox" class="remove_box" name="remove_box[]" value="' . $cf->get_id() . '" /></td>
                        <td class="normal_column">
                            <a href="' . AREA . '&amp;view=edit&amp;id=' . $cf->get_id() . '"><span class="main_text">' . $cf->get_email() . '</span></a>
                            <div class="row_actions">
                                <a href="' . AREA . '&amp;view=edit&amp;id=' . $cf->get_id() . '">' . $pec_localization->get('ACTION_EDIT') . '</a> - 
                                <a href="javascript:ask(\'' . $pec_localization->get('PLUGIN_CONTACTFORM_REALLY_REMOVE') . '\', \'' . AREA . '&amp;view=default&amp;action=remove&amp;id=' . $cf->get_id() . '\');">' . $pec_localization->get('ACTION_REMOVE') . '</a>
                            </div>
                        </td>
                        <td class="normal_column">' . $cf->get_id() . '</td>
                    </tr>
        ';
    }
    
    $area_data['content'] .= '
            </table>
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
              
    case 'edit':
        $area_data = view_edit();
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
