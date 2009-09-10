function BaseModel() {
	var self = this;
	this.return_data;
	
	this.data_adapter = function(sendData, controller, listener) {
		$.ajax({
		  async: true, // default
		  contentType: 'application/x-www-form-urlencoded', //default
		  data: sendData, 
		  dataType: 'json',
		  error: function(returnData, textStatus, errorThrown) { console.log("SendMessage Ajax broken: " + textStatus);  },
		  success: function(returnData, textStatus) { self.return_data = returnData; $.event.trigger(listener); },
		  timeout: 20000, // milliseconds
		  url: '/' + controller,
		  type: 'post'
		});	
	}
	
	this.get_data = function() {
		return self.return_data;
	}
}