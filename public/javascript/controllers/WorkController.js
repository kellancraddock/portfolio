WorkController.prototype = new BaseController();
//All event binding and passing of data from the model to the views goes here
function WorkController() {
	var self = this;
	this.interval;
	this.slideshow_model;
	this.gallery;
	this.thumbs;
	this.controls;
	this.callouts;
	this.views;
	
	//Constructor
	this.construct = function() {
		//Slideshow Model
		self.slideshow_model = new SlideShowModel();
		
		//Controller variables
		self.gallery = $('#gallery .project_images');
		self.thumbs = $('#thumbs ul.thumbs');
		self.controls = $('#thumbs span.control');
		self.callouts = $('.callouts.work', '#main_container');
		self.views = $('li.views ul.project_views', self.callouts);
		
		//Set thumbs view variables
		self.view.thumbs_gallery.gallery = self.thumbs;
		self.view.thumbs_gallery.slide_width = 194;
		self.view.thumbs_gallery.off_set = 2;
		self.view.thumbs_gallery.controls = self.controls;
		self.view.thumbs_gallery.callouts = self.callouts
		self.view.thumbs_gallery.slideshow_setwidth();
		
		//Set work view variables
		self.view.work_gallery.gallery = self.gallery;
		self.view.work_gallery.thumbs = self.thumbs;
		self.view.work_gallery.views = self.views;
		self.view.work_gallery.slide_width = 1000;
		var id = $('.active', self.thumbs).attr('id');
		self.view.work_gallery.slideshow_load('next', id);
		self.view.work_gallery.slideshow_setwidth();
		self.view.work_gallery.slideshow_unload();
		self.view.work_gallery.slideshow_setwidth();
				
		//Bind controls hide show events
		self.thumbs.parent('#thumbs').hover(function(e) {
			self.view.thumbs_gallery.controls_show();	
		}, function(e) {
			setTimeout(function() {
				self.view.thumbs_gallery.controls_hide();
			}, 300);
		});
		
		//Bind thumbs click events
		self.thumbs.children('li').bind('click', function(e) {
			e.preventDefault();
			self.view.preloader.start('Loading project');
			
			var id = $(this).attr('id');
			var new_project = self.view.thumbs_gallery.slideshow_center(this);
			var direction = self.view.work_gallery.slideshow_center(this, id);
			self.updateInfoAction.manual(new_project, function(response) {
				self.view.thumbs_gallery.project_update(response);
				self.view.preloader.stop();
				self.view.work_gallery.slideshow_load(direction, id);
				self.view.work_gallery.slideshow_setwidth();
				if(direction == 'next') {
					self.view.work_gallery.slideshow_next(function() {
						self.view.work_gallery.slideshow_setwidth();
						self.view.work_gallery.slideshow_unload();
						$(self.gallery).css({'marginLeft': 0});
						self.view.work_gallery.slideshow_setwidth();
					});
				} else {
					self.view.work_gallery.slideshow_prev(function() {
						self.view.work_gallery.slideshow_setwidth();
						self.view.work_gallery.slideshow_unload();
						self.view.work_gallery.slideshow_setwidth();
					});
				}
			});
		});
		
		//Bind controls move click events
		$('a.left', self.controls).bind('click', function() {
			if ($('.active', self.thumbs).prev('li').length) {
				self.view.preloader.start('Loading project');
				self.controlsAction.prev();
			}
			return false;
		});
		
		$('a.right', self.controls).bind('click', function() {
			if ($('.active', self.thumbs).next('li').length) {
				self.view.preloader.start('Loading project');
				self.controlsAction.next();
			}
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
			if(self.view.thumbs_gallery.slideshow_load(response)) {
				self.controlsAction.auto();
			} else {
				self.view.alert('error', 'Error Loading Projects');
			};
		});
	}
	
	this.controlsAction = {
		next: function() {
				if ($('.active', self.thumbs).next('li').length) {
					self.view.thumbs_gallery.slideshow_resetactive($('.active', self.thumbs).next('li'));
					var new_project = self.view.thumbs_gallery.slideshow_next();
				}
				self.updateInfoAction.manual(new_project, function(response) {
					self.view.thumbs_gallery.project_update(response);
					self.view.preloader.stop();
					var id = $('.active', self.thumbs).attr('id');
					self.view.work_gallery.slideshow_load('next', id);
					self.view.work_gallery.slideshow_setwidth();
					
					self.view.work_gallery.slideshow_next(function() {
						self.view.work_gallery.slideshow_unload();
						$(self.gallery).css({'marginLeft': 0});
						self.view.work_gallery.slideshow_setwidth();
					});
				});
			},
		prev: function() {
				if ($('.active', self.thumbs).prev('li').length) {
					self.view.thumbs_gallery.slideshow_resetactive($('.active', self.thumbs).prev('li'));
					var new_project = self.view.thumbs_gallery.slideshow_prev();
				}
				self.updateInfoAction.manual(new_project, function(response) {
					self.view.thumbs_gallery.project_update(response);
					self.view.preloader.stop();
					var id = $('.active', self.thumbs).attr('id');
					self.view.work_gallery.slideshow_load('prev', id);
					self.view.work_gallery.slideshow_setwidth();
					
					self.view.work_gallery.slideshow_prev(function() {
						self.view.work_gallery.slideshow_setwidth();
						self.view.work_gallery.slideshow_unload();
						self.view.work_gallery.slideshow_setwidth();
					});
				});
			}
	}
	
	this.updateInfoAction = {
		manual: function(id, fn) {
			self.slideshow_model.getOne({
				data : 'id=' + id,
				location : 'work/project',
			}, (fn) ? fn : function(response) {
				self.view.thumbs_gallery.project_update(response);
				self.view.preloader.stop();
			});
		}
	}
	
	self.construct();
}

$(function() {
	new WorkController();	
});

