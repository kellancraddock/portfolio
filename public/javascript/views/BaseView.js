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
	
	this.preloader = {
	
		start : function(message) {
					$('#preloader p').html(message);
					$('#preloader').fadeIn('fast');
				},
		stop : function() {
					setTimeout(function() {
						$('#preloader').fadeOut('slow', function() {
							$('p', this).html('');
						});
					}, 600);
				}
	}
}