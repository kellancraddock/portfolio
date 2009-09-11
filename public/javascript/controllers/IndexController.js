IndexController.prototype = new BaseController();
//All event binding and passing of data from the model to the views goes here
function IndexController() {
	var self = this;
	this.interval;
	this.slideshow_model;
	
	//Constructor
	this.construct = function() {
		self.slideshow_model = new SlideShowModel();
		self.slideshowAction();
		
		$('#gallery').bind('mouseover', function() {
			self.stopAction();	
		}).bind('mouseout', function() {
			self.startAction();
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
				self.startAction();
			} else {
				self.view.alert('error', 'Error Loading Projects');
			};
		});
	}
	
	this.startAction = function() {
		//Set SlideShow interval
		self.interval = setInterval(function() {
			var new_project = self.view.slideshow_move();
			(new_project) ? self.updateInfoAction(new_project) : self.updateInfoAction(self.view.slideshow_reset());
		}, 4000);
	}
	
	this.stopAction = function() {
		clearInterval(self.interval);
	}
	
	this.updateInfoAction = function(id) {
		self.slideshow_model.getOne({
			data : 'id=' + id,
			location : 'index/info',
		}, function(response) {
			self.view.updateControlls(response);
		});
	}
	
	self.construct();
}

$(function() {
	new IndexController();	
});

