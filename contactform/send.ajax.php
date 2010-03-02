<?php

if (isset($_POST['cf_name']) && isset($_POST['cf_email']) && isset($_POST['cf_subject']) && 
    isset($_POST['cf_message']) && isset($_POST['cf_id'])  && isset($_POST['cf_plugin_directory'])) {

    /* core includes, creating core objects */
    require_once('../../pec_includes/functions.inc.php');
    define_constants(2, 'pec_plugins/' . stripslashes($_POST['cf_plugin_directory']));
    require_once('../../pec_core.inc.php');
    /* core include end */

    if (!empty($_POST['cf_name']) && !empty($_POST['cf_email']) && !empty($_POST['cf_subject']) && 
        !empty($_POST['cf_message']) && !empty($_POST['cf_id']) && !empty($_POST['cf_plugin_directory'])) {

        if (email_syntax_correct($_POST['cf_email']) && email_host_exists($_POST['cf_email'])) {

            require('classes/contactform.class.php');

            if (Contactform::exists('id', $_POST['cf_id'])) {

                $contactform = Contactform::load('id', $_POST['cf_id']);

                $sender_name = $_POST['cf_name'];
                $sender_email = $_POST['cf_email'];
                $sender_subject = stripslashes($_POST['cf_subject']);
                $sender_message = stripslashes($_POST['cf_message']);

                $website_name = $pec_settings->get_sitename_main();

                $email_text  = 
"
Hi,

$sender_name <$sender_email> has sent you a message from you website \"$website_name\".

--------
Subject: $sender_subject

$sender_message
--------

Kind regards,
Your Server
";

                $email_subject = 'Message from ' . $sender_name;

                try {
                    mail($contactform->get_email(), $email_subject, $email_text);
                }
                catch (Exception $e) {                
                    $info = get_intern_template(message_tpl_file(MESSAGE_WARNING));
                    $info = str_replace('{%TITLE%}', 'Error', $info);
                    $info = str_replace('{%CONTENT%}', 'An error occurrec while sending your message.', $info);
                    die($info);
                }

                
                $info = get_intern_template(message_tpl_file(MESSAGE_INFO));
                $info = str_replace('{%TITLE%}', 'Successfully sent', $info);
                $info = str_replace('{%CONTENT%}', 'You have successfully sent the message.', $info);
                echo $info;
            }
            else {
                $info = get_intern_template(message_tpl_file(MESSAGE_WARNING));
                $info = str_replace('{%TITLE%}', 'Contactform does not exist', $info);
                $info = str_replace('{%CONTENT%}', 'The given contactform does not exist.', $info);
                echo $info;
            }
        }
        else {
            $info = get_intern_template(message_tpl_file(MESSAGE_WARNING));
            $info = str_replace('{%TITLE%}', 'Email incorrect', $info);
            $info = str_replace('{%CONTENT%}', 'You have to enter a correct Email address.', $info);
            echo $info;
        }
    }
    else {
        $info = get_intern_template(message_tpl_file(MESSAGE_WARNING));
        $info = str_replace('{%TITLE%}', 'All fields required', $info);
        $info = str_replace('{%CONTENT%}', 'You have to fill out all fields.', $info);
        echo $info;
    }
}
?>
