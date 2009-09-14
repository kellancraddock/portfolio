WorkController.prototype = new BaseController();
//All event binding and passing of data from the model to the views goes here
function WorkController() {
	var self = this;
	this.interval;
	this.slideshow_model;
	this.gallery;
	this.controls;
	this.callouts;
	
	//Constructor
	this.construct = function() {
		//Slideshow Model
		self.slideshow_model = new SlideShowModel();
		
		self.gallery = $('#thumbs ul.thumbs');
		self.controls = $('#thumbs span.control');
		self.callouts = $('.callouts.work', '#main_container');
		
		//Set view variables
		self.view.gallery = self.gallery;
		self.view.slide_width = 194;
		self.view.off_set = 2;
		self.view.controls = self.controls;
		self.view.callouts = self.callouts
		self.view.slideshow_setwidth();
		
		//Bind controls hide show events
		self.gallery.parent('#thumbs').hover(function(e) {
			self.view.controls_show();	
		}, function(e) {
			setTimeout(function() {
				self.view.controls_hide();
			}, 300);
		});
		
		//Bind thumbs click events
		self.gallery.children('li').bind('click', function(e) {
			e.preventDefault();
			var new_project = self.view.slideshow_center(this);
			self.updateInfoAction.manual(new_project);
		});
		
		//Bind controls move click events
		$('a.left', self.controls).bind('click', function() {
			self.controlsAction.prev();
			return false;
		});
		
		$('a.right', self.controls).bind('click', function() {
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
			if(self.view.slideshow_load(response)) {
				self.controlsAction.auto();
			} else {
				self.view.alert('error', 'Error Loading Projects');
			};
		});
	}
	
	this.controlsAction = {
		next: function() {
				if ($('.active', self.gallery).next('li').length) {
					self.view.slideshow_resetactive($('.active', self.gallery).next('li'));
					var new_project = self.view.slideshow_next();
					console.log(new_project);
				}
				self.updateInfoAction.manual(new_project);
			},
		prev: function() {
				if ($('.active', self.gallery).prev('li').length) {
					self.view.slideshow_resetactive($('.active', self.gallery).prev('li'));
					var new_project = self.view.slideshow_prev();
					console.log(new_project);
				}
				self.updateInfoAction.manual(new_project);
			}
	}
	
	this.updateInfoAction = {
		manual: function(id) {
			self.slideshow_model.getOne({
				data : 'id=' + id,
				location : 'work/project',
			}, function(response) {
				self.view.project_update(response);
			});
		}
	}
	
	self.construct();
}

$(function() {
	new WorkController();	
});

