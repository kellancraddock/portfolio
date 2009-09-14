View.prototype = new BaseView();

function View() {
	var self = this;
	
	this.main_gallery = new Gallery();
	this.work_gallery = new Gallery();
}

