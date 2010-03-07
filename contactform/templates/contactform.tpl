<br /><div id="contactform_info_box_{%ID%}"></div> 

<noscript>
    <i>{%CF_MUST_ENABLE_JS%}</i><br /><br />
</noscript>

<form name="contactform_plugin_{%ID%}" id="contactform_plugin_{%ID%}">
    <table cellpadding="2">
        <tr>
            <td>{%CF_NAME%}: </td>
            <td><input size="30" type="text" name="cf_from_name" value="" /></td>
        </tr>
        <tr>
            <td>{%CF_EMAIL%}: </td>
            <td><input size="30" type="text" name="cf_from_email" value="" /></td>
        </tr>
        <tr>
            <td>{%CF_SUBJ%}: </td>
            <td><input size="30" type="text" name="cf_from_subj" value="" /></td>
        </tr>
        <tr>
            <td valign="top">{%CF_MSG%}: </td>
            <td><textarea cols="40" rows="10" name="cf_from_msg" /></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td align="right"><input type="button" onclick="send_contactform_mail('{%AJAX_SEND_FILE_URL%}', 'contactform_plugin_{%ID%}', 'contactform_info_box_{%ID%}')" value="{%CF_SEND%}" /></td>
        </tr>
    </table>
    <input type="hidden" name="cf_id" value="{%ID%}" />
    <input type="hidden" name="cf_plugin_dir" value="{%PLUGIN_DIRECTORY%}" />
</form>
