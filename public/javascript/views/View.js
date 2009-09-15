View.prototype = new BaseView();

function View() {
	var self = this;
	//main gallery
	this.main_gallery = new Gallery();
	
	//work gallery
	this.work_gallery = new Gallery();
	
	//Override load function of work gallery
	this.work_gallery.slideshow_load = function(direction, id) {
		var new_images = '';
		this.gallery.children('li').removeClass('active');
		$('li', this.views).each(function(i) {
			var src = $(this).children('a').children('img').attr('src');
			var view_title = $(this).attr('title');
			var is_active = (i == 0) ? ' class="active"' : '';
			new_images += '<li' + is_active + ' title="' + id + '" id="' + view_title + '"><img alt="project image" src="' + src + '"/></li>';
		});
		this.gallery.children('li').addClass('inactive');
		if (direction == 'next') {
			this.gallery.append(new_images);
		} else if (direction == 'prev') {
			this.gallery.prepend(new_images);
		}
	}
	
	//Override work gallery slideshow center
	this.work_gallery.slideshow_center = function(active, id) {
		//Check to see which way to move based on comparing the active items title attribute with the thumbs id
		if ($('.active', this.gallery).attr('title') < id) {
			return 'next';
		} else {
			return 'prev';
		}
	}
	
	this.work_gallery.slideshow_prev = function(fn) {
		var margin = ($('.inactive:first', this.gallery).prevAll('li').length - this.off_set) * this.slide_width;
		this.gallery.css({
			"marginLeft": '-' + margin + 'px'
		}).animate({
			marginLeft : 0,
			duration: 2300
		}, (fn) ? fn : function() {});
		return $('.active', self.gallery).attr('id');
	}
	
	this.work_gallery.slideshow_unload = function() {
		$('.inactive', this.gallery).remove();
	}
	
	//thumbs gallery
	this.thumbs_gallery = new Gallery();
	
	//Views Gallery
	this.views_gallery = new Gallery();
}

