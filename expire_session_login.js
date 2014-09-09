$(document).ready(function() {
	if (window.rcmail) {
		rcmail.addEventListener('init', function() {		
			// create "stay logged in" checkbox.
			var	text = '<tr>';
				text+= '  <td colspan="2" class="title">';
				text+= '    <label><input type="checkbox" name="_keep_session" id="keep_session" value="yes" checked/>' + rcmail.gettext('keep_me_signed_in', 'expire_session') + '</label>';
				text+= '  </td>';
				text+= '</tr>';
			
			var element = $('#login-form > div.box-inner > form > table > tbody');
			if (element && element.length !== 0) {
				element.append(text);
			}
			else {
				$('form').append(text);
			}		
		});
	}
	
});
