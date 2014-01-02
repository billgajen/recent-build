$(function() {
	var gallery = (function(){
		var list = $('.thumbs li a'),
			preview = $('.preview');
			
		function showFirst(){
			var firstImgLoc = list.first().attr('href'),
				firstImgLocSpilt = firstImgLoc.split('/'),
				image = firstImgLocSpilt[firstImgLocSpilt.length - 1],
				imageTag = '<img src="'+ firstImgLoc +'" alt="'+ image +'" />';

				preview.html(imageTag)
		}

		function clickToPreview(){
			list.click(function(e){
				var loc = $(this).attr('href'),
					locSplit = loc.split('/'),
					imgName = locSplit[locSplit.length - 1],
					previewImg = $('.preview img');

				previewImg.attr({
					src: loc,
					alt: imgName
				});
				e.preventDefault();
			});
		}

		return {
			showFirst: showFirst,
			clickToPreview: clickToPreview
		}
	})();
	gallery.showFirst();
	gallery.clickToPreview();

});
