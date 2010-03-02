function send_contactform_mail(ajax_file_url, form, info_box_id) {
    var cf_sender = document.forms[form].cf_from_name.value;
    var cf_email = document.forms[form].cf_from_email.value;
    var cf_subject = document.forms[form].cf_from_subj.value;
    var cf_message = document.forms[form].cf_from_msg.value;

    var cf_id = document.forms[form].cf_id.value;
    var cf_plugin_directory = document.forms[form].cf_plugin_dir.value;
    
    var params = 
        "cf_name=" + cf_sender + 
        "&cf_email=" + cf_email + 
        "&cf_subject=" + cf_subject + 
        "&cf_message=" + cf_message + 
        "&cf_id=" + cf_id + 
        "&cf_plugin_directory=" + cf_plugin_directory;    

    var req = new Request.HTML({
        method: "post", 
        url: ajax_file_url,
        onSuccess: function(responseTree, responseElements, responseHTML) {
            document.getElementById(info_box_id).innerHTML = responseHTML;
        }
    });
    
    req.send(params);
}
