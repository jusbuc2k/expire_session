$(document).ready(function() {

	if (window.rcmail) {

		rcmail.addEventListener('init', function() {		
			// create "stay logged in" checkbox.
			var	text = '<div id="expire_session_form">';
				text+= '  <div>';
				text+= '    <label><input type="checkbox" name="_keep_session" id="keep_session" value="yes" checked/>' + rcmail.gettext('keep_me_signed_in', 'expire_session') + '</label>';
				text+= '  </div>';
				text+= '</div>';
			
			var element = $('div.boxcontent > form');
			if (element && element.length !== 0) {
				element.append(text);
			}
			else {
				$('form').append(text);
			}		
		});
	}
	
});
