$(function(){
	function Carousel(container, button) {
		this.container = container;
		this.button = this.container.parent().find(button);
		this.imgs = this.container.find('img');
		this.imgWidth = this.imgs[0].width;
		this.imgHeight = this.imgs[0].height;
		this.imgsLen = this.imgs.length;
		this.containerWidth = this.container.css({
			width: this.imgWidth * this.imgsLen
		});
		this.holderdimesions = this.container.parent().css({
			width: this.imgWidth,
			height: this.imgHeight
		});
		this.current = 0;
	}

	Carousel.prototype.transition = function(coords) {
		this.container.css({
			'margin-left': coords || -(this.current * this.imgWidth)
		});
	};

	Carousel.prototype.currentPosition = function(click) {
		(click === 'next') ? this.current++ : this.current--;
		this.current = (this.current < 0) ? this.imgsLen - 1 : this.current % this.imgsLen;
	};

	
	// Carousel.prototype.autoRotation = function() {
	// 	var cont = this.container,
	// 		current = this.current,
	// 		imgWidth = this.imgWidth,
	// 		length = this.imgsLen - 1;
	// 	setInterval(function() {
	// 		if(current >= length) {
	// 			current = 0
	// 		} else if(current == 0) {
	// 			current++
	// 		} else {
	// 			current ++
	// 		}
	// 		// console.log(current);
	// 		cont.css({
	// 			'margin-left': -(current * imgWidth)
	// 		});
	// 	}, 4000)
	// };

	var slider = new Carousel($('.carousel ul'), $('button'));
	//slider.autoRotation();
	slider.button.on('click', function(){
		slider.currentPosition($(this).data('click'));
		slider.transition();
	});
	var lilSlider = new Carousel($('.lilCarousel ul'), $('button'));
	lilSlider.button.on('click', function(){
		lilSlider.currentPosition($(this).data('click'));
		lilSlider.transition();
	});
});
