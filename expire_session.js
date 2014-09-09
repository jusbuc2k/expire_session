$(document).ready(function() {

	if (window.rcmail) {
	
		$.ajaxSetup({
			error: function(xhr, textStatus, error){
				if (textStatus === '302'){
					console.log('Session is expired because a redirect was detected.');
				}
			}
		});	

	}
	
});
