View.prototype = new BaseView();

function View() {
	var self = this;
	this.slide_width = 1000;
	
	this.slideshow_load = function(images) {
		try {
			self.project_images = $('#gallery .project_images');
			$(images).each(function(i) {
				self.project_images.append('<li id="' + images[i]['project_id'] + '"><img src="/uploads/' + images[i]['file_name'] + '" /></li>')
			});
	
			self.slideshow_setwidth();
			
			return true;
		} catch (e) {
			return false;
		}
	}
	
	this.slideshow_move = function() {
		if ($('.active', $('#gallery .project_images')).next('li').length > 0) {
			self.slideshow_resetactive($('.active', $('#gallery .project_images')).next('li'));
			var margin = ($('.active', $('#gallery .project_images')).prevAll('li').length) * self.slide_width;
			$('#gallery .project_images').animate({
				marginLeft : '-' + margin + 'px' 
			});
			return $('.active', '#gallery .project_images').attr('id');
		} else {
			return false;
		}
	}
	
	this.slideshow_setwidth = function() {
		var width = $('#gallery .project_images li').length * self.slide_width;
		$('#gallery .project_images').css({'width' : width});
	}
	
	this.slideshow_resetactive = function(active) {
		$('#gallery .project_images li').removeClass('active');
		$(active).addClass('active');
	}
	
	this.slideshow_reset = function() {
		$('#gallery .project_images li').removeClass('active');
		$('#gallery .project_images li:first').addClass('active');
			
		$('#gallery .project_images').animate({
			marginLeft : '0px'
		});
		return $('.active', '#gallery .project_images').attr('id');
	}
	
	this.updateControlls = function(response) {
		console.log(response['id']);
		$('.gallery_controls h2', '#gallery').html(response['title']);
		$('.gallery_controls p', '#gallery').html(response['description']);
		$('.gallery_controls .nav .launch_btn a', '#gallery').attr('href', '/work/project/id/' + response['id']);
	}
}