IndexController.prototype = new BaseController();
//All event binding and passing of data from the model to the views goes here
function IndexController() {
	var self = this;
	//Constructor
	this.construct = function() {
		self.slideshowAction();
		self.newAction();
	}
	
	this.slideshowAction = function() {
		var slideshow_model = new SlideShowModel();
		slideshow_model.request('id=26', 'index', 'slideshow_data');
		$(this).bind('slideshow_data', function() {
			var returnData = slideshow_model.get_data();
			self.view.alert('fail', returnData);
		});		
	}
	
	this.newAction = function() {
		var slideshow_model = new SlideShowModel();
		slideshow_model.request('id=26', 'index', 'new_data');
		$(this).bind('new_data', function() {
			var returnData = slideshow_model.get_data();
			console.log('new');
		});		
	}
	
	self.construct();
}

$(function() {
	new IndexController();	
});

