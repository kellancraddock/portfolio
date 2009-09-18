IndexController.prototype = new BaseController();
//All event binding and passing of data from the model to the views goes here
function IndexController() {
	var self = this;
	this.interval;
	this.slideshow_model;
	this.gallery;
	
	//Constructor
	this.construct = function() {
		self.slideshow_model = new SlideShowModel();
		self.slideshowAction();
		
		self.gallery = $('#gallery .project_images');
		
		//Set view variables
		self.view.main_gallery.gallery = self.gallery;
		self.view.main_gallery.slide_width = 1000;
		self.view.main_gallery.off_set = 0;
		self.view.main_gallery.slideshow_setwidth();
		
		//reset control position
		self.view.main_gallery.controls_move({direction : 'up'});
		
		$('#gallery').bind('mouseenter', function() {
			self.controlsAction.pause();	
		}).bind('mouseleave', function() {
			setTimeout(function() {
				self.view.main_gallery.controls_move({direction : 'up'});
			}, 500);
			self.controlsAction.auto();
		});
		
		$('.left a', '.controls_wrapper').bind('click', function(e) {
			self.controlsAction.prev();
			return false;
		});
		
		$('.right a', '.controls_wrapper').bind('click', function(e) {
			self.controlsAction.next();
			return false;
		});
	}
	
	this.slideshowAction = function() {
		var current_project = $('li.active', '#gallery .project_images').attr('id');
		
		//Make initial request on page load		
		self.slideshow_model.getExtras({
			data : 'id=' + current_project, 
			location : 'index/images', 
		}, function(response) {
			if(self.view.main_gallery.slideshow_load(response)) {
				self.controlsAction.auto();
			} else {
				self.view.alert('error', 'Error Loading Projects');
			};
		});
	}
	
	this.controlsAction = {
		auto: function() {
				//Set SlideShow interval
				self.interval = setInterval(function() {
					self.view.main_gallery.controls_move({direction : 'down'});
					setTimeout(function() {
						if ($('.active', self.gallery).next('li').length) {
							self.view.main_gallery.slideshow_resetactive($('.active', self.gallery).next('li'));
							var new_project = self.view.main_gallery.slideshow_next({});
						}
						(new_project) ? self.updateInfoAction.auto(new_project) : self.updateInfoAction.auto(self.view.main_gallery.slideshow_reset());
					}, 600);
				}, 8000);
			},
		next: function() {
				if ($('.active', self.gallery).next('li').length) {
					self.view.main_gallery.slideshow_resetactive($('.active', self.gallery).next('li'));
					var new_project = self.view.main_gallery.slideshow_next({});
				}
				(new_project) ? self.updateInfoAction.manual(new_project) : self.updateInfoAction.manual(self.view.main_gallery.slideshow_reset());
			},
		prev: function() {
				if ($('.active', self.gallery).prev('li').length) {
					self.view.main_gallery.slideshow_resetactive($('.active', self.gallery).prev('li'));
					var new_project = self.view.main_gallery.slideshow_prev({});
				}
				(new_project) ? self.updateInfoAction.manual(new_project) : self.updateInfoAction.manual(self.view.main_gallery.slideshow_reset());
			},
		pause: function() {
			clearInterval(self.interval);
			self.view.main_gallery.controls_move({direction : 'open'});
			}
	}
	
	this.updateInfoAction = {
		auto: function(id) {
			self.slideshow_model.getOne({
				data : 'id=' + id,
				location : 'index/info',
			}, function(response) {
				self.view.main_gallery.controls_update(response);
				self.view.main_gallery.controls_move({direction : 'up'});
			});
		},
		manual: function(id) {
			self.slideshow_model.getOne({
				data : 'id=' + id,
				location : 'index/info',
			}, function(response) {
				self.view.main_gallery.controls_update(response);
			});
		}
	}
	
	self.construct();
}

$(function() {
	new IndexController();	
});

