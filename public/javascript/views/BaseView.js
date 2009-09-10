function BaseView() {
	this.alert = function(type, message) {
		$('#alert').addClass(type).html(message).fadeIn('fast', function() {
			setTimeout(function() {
				$('#alert').fadeOut('slow', function() {
					$(this).html('');
				});
				
			}, 2000);
		}); 
	}
}