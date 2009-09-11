SlideShowModel.prototype = new BaseModel();

function SlideShowModel() {
	var self = this;
	
	this.getExtras = function(object, callback) {
		self.data_adapter(object, callback);
	}
	
	this.getOne = function(object, callback) {
		self.data_adapter(object, callback);
	}
}
