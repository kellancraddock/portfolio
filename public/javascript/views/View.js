View.prototype = new BaseView();

function View() {
	var self = this;
	this.slide_width;
	this.off_set;
	this.gallery;
	this.controls;
	
	this.slideshow_load = function(images) {
		try {
			$(images).each(function(i) {
				self.gallery.append('<li id="' + images[i]['project_id'] + '"><img src="/uploads/' + images[i]['file_name'] + '" /></li>')
			});
	
			self.slideshow_setwidth();
			
			return true;
		} catch (e) {
			return false;
		}
	}
	
	this.slideshow_next = function() {
		var margin = ($('.active', self.gallery).prevAll('li').length - self.off_set) * self.slide_width;
		self.gallery.stop().animate({
			marginLeft : '-' + margin + 'px' 
		});
		return $('.active', self.gallery).attr('id');
	}
	
	this.slideshow_prev = function() {
		var margin = ($('.active', self.gallery).prevAll('li').length - self.off_set) * self.slide_width;
		self.gallery.animate({
			marginLeft : '-' + margin + 'px' 
		});
		return $('.active', self.gallery).attr('id');
	}
	
	this.slideshow_center = function(active) {
		self.slideshow_resetactive(active);
		//Check to see which side of the active has more items them move
		if ($('.active', self.gallery).prev('li').length > $('.active', self.gallery).next('li').length) {
			self.slideshow_next();
		} else {
			self.slideshow_prev();
		}
	}
	
	this.slideshow_setwidth = function() {
		var width = $('li', self.gallery).length * self.slide_width;
		self.gallery.css({'width' : width});
	}
	
	this.slideshow_resetactive = function(active) {
		$('li', self.gallery).removeClass('active');
		$(active).addClass('active');
	}
	
	this.slideshow_reset = function() {
		$('li', self.gallery).removeClass('active');
		$('li:first', self.gallery).addClass('active');
			
		self.gallery.animate({
			marginLeft : '0px'
		});
		return $('.active', self.gallery).attr('id');
	}
	
	this.controls_update = function(response) {
		$('.gallery_controls h2', '#gallery').html(response['title']);
		$('.gallery_controls p', '#gallery').html(response['description']);
		$('.gallery_controls .nav .launch_btn a', '#gallery').attr('href', '/work/project/id/' + response['id']);
	}
	
	this.controls_move = function(object) {
		self.controls = $('.gallery_controls', '.controls_wrapper');
		var header_height = 42;
		var total_height = self.controls.height();
		var adjusted_height = (total_height - header_height);
		
		self.controls = $('.gallery_controls', '.controls_wrapper');
		if (object.direction == 'down') {
			self.controls.stop().animate({
				bottom : '-' + total_height + 'px',
				duration: 1000,
				easing : 'easeOutbounce'
			});
		} else if(object.direction == 'up') {
			self.controls.stop().animate({
				bottom : '-' + adjusted_height + 'px',
				duration: 1000,
				easing : 'easeOutbounce'
			});
		} else if(object.direction == 'open') {
			self.controls.stop().animate({
				bottom : '0px'
			}, 500);
		}
	}
	
	this.controls_show = function() {
		self.controls.fadeIn('fast');
	}
	
	this.controls_hide = function() {
		self.controls.fadeOut('fast');
	}
}

