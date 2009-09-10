SlideShowModel.prototype = new BaseModel();

function SlideShowModel() {
	var self = this;
	this.request = function(data, controller, listener) {
		self.data_adapter(data, controller, listener);
	}
}
