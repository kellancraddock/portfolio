function ExternalLinks(element) {
	var self = this;
	this.root = element;
	
	this.construct = function() {
		$('a.external', self.root).bind('click', function() {
			var location = $(this).attr('href');
			window.open(location);
			return false;
		});
	}()
}