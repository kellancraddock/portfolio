function BaseModel() {
	var self = this;
	
	this.data_adapter = function(object, callback) {
		self.data = (object.data) ? object.data : '';
		self.location = (object.location) ? object.location : '';
		
		$.ajax({
		  async: true, // default
		  contentType: 'application/x-www-form-urlencoded', //default
		  data: self.data, 
		  dataType: 'json',
		  error: function(returnData, textStatus, errorThrown) { callback(returnData) },
		  success: function(returnData, textStatus) { callback(returnData) },
		  timeout: 20000, // milliseconds
		  url: '/' + self.location,
		  type: 'post'
		});	
	}
}