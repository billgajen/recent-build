(function() {

	// Login

	$('.button').on('click', function() {
		
		var action = $('#login').attr('action'),
			username=$('#username').val(),
			password=$('#password').val();
		
		$.ajax({
			type: 'post',
			url: action,
			data: "username="+username+"&password="+password,
			success: function(response)
			{
				if(response == 'true') {
					$('.message .error').hide(),
					$('ul.slide-container').animate({
						left: '-320px'
					}, 500);
				} else {
					$('.message').html("<p class='error'>Invalid username and/or password.</p>");	
				}
			},

			beforeSend:function()
		   {
		    $('.message').html("<p class='error'>Loading...</p>")
		   }

		});

		$.ajax({                                      
			url: 'php/process.php',
			data: "username="+username+"&password="+password,
			dataType: 'json',
			success: function(data)
				{
					var fname = data[3];
					$('.step2 h2').html('Welcome '+fname);
				} 
		});

		return false;

	});

	// Remove other input values within date picker

	var input = $('#date-picker input[type=date]');

	input.focus(function() {
		input.not(this).val('');
	});

	// Show Records

	$('.getData').on('click', function() {
		var date = $('#single-day').val(),
			week = $('#week').val();

		if (date.length) {

			$.ajax({
				url: 'php/timesheet.php',
				data: "date="+date,
				dataType: 'json',
				success: function(data)
				{
					if (data == false ) {
						$('.time-message').html("<p class='error'>No records found.</p>");
					} else {
						$('.time-message .error').hide();
						//$('.step3 h3').html(date);
						var i = 0,
							l = data.length,
							html = '<ul class="time-table">';

						html += '<h3>' + data[i].timeSlots.tdate + '</h3>';	
						html += '<li>';

						for (; i < l; i++) {
							html += '<table>';
								html += '<tr>';
									html += '<td class="job-code">'+ data[i].timeSlots.jobcode +'</td>';
									html += '<td class="job-description">'+ data[i].timeSlots.job +'</td>';
								html += '</tr>';
								html += '<tr>';
									html += '<td class="pmam">'+ data[i].timeSlots.pmam +'</td>';
									html += '<td class="assigned-hours">'+ data[i].timeSlots.assiHours +'</td>';
									html += '<td contenteditable="true" class="added-hours">'+ data[i].timeSlots.addedHours +'</td>';
									html += '<td class="add"><img src="img/plus.png" alt="add" /></td>';
								html += '</tr>';
							html += '</table>';
						}
						html += '</li>';
						html += '</ul>';

						$('.step3').append(html);

						$('ul.slide-container').animate({
							left: '-640px'
						}, 500).ready(function() {

							autoTimeAdd();
							
						});
					}
				} 
			});

		} else if (week.length) {

			$.ajax({
				url: 'php/week.php',
				data: "date="+week,
				dataType: 'json',
				success: function(data)
				{
					if (data == false ) {
						$('.time-message').html("<p class='error'>No records found.</p>");
					} else {
						$('.time-message .error').hide();

                    var j=0,
                        i=0,
                        l = data.length,
                        html = '<ul class="time-table">';

                    for (; j < l; j++) {
                        if(j != 0){
                            while(data[j].timeSlots.tdate == data[i].timeSlots.tdate){
                                j++;
                            }
                        }

                        html += '<h3>' + data[j].timeSlots.tdate + '</h3><li>';
                        for (; i < l; i++) {
                            if(data[j].timeSlots.tdate === data[i].timeSlots.tdate){
                                html += '<table>';
                                    html += '<tr>';
                                        html += '<td class="job-code">'+ data[i].timeSlots.jobcode +'</td>';
                                        html += '<td class="job-description">'+ data[i].timeSlots.job +'</td>';
                                    html += '</tr>';
                                    html += '<tr>';
                                        html += '<td class="pmam">'+ data[i].timeSlots.pmam +'</td>';
                                        html += '<td class="assigned-hours">'+ data[i].timeSlots.assiHours +'</td>';
                                        html += '<td contenteditable="true" class="added-hours">'+ data[i].timeSlots.addedHours +'</td>';
                                        html += '<td class="add">add</td>';
                                    html += '</tr>';
                                html += '</table>';
                            }
                        }
                        

                        i = j;
                                        
                        html += '</li>';

                    }              

                    html += '</ul>'

                    $('.step3').append(html);

                    $('ul.slide-container').animate({
                                    left: '-640px'
                    }, 500).ready(function() {

							autoTimeAdd();

						});
					}
				} 
			});

		} else {
			$('.time-message').html("<p class='error'>Please select a date</p>");
		}

		return false;
	});

	// Add time Manual

	$('.add-by-jobcode').on('click', function(){

		var mdate=$('#mdate').val(),
			jobcode=$('#jobcode').val(),
			hours=$('#hours').val();

		if (mdate.length && jobcode.length && hours.length) {

			$.post('php/insert.php', {date: mdate, jobcode: jobcode, hours: hours},
				function(data){
					$('.time-message').html("<p class='error'>" + data + "</p>");
					$('.time-message .error').css('opacity', '1').animate({'opacity': '0'}, 3500); 
			});
			return false;

		} else {
			$('.time-message').html("<p class='error'>Please fill in all the fields</p>");
			$('.time-message .error').css('opacity', '1').animate({'opacity': '0'}, 3500); 
		}

	});


	$('#logout').on('click', function(e) {
		$('ul.slide-container').animate({
			left: '0px'
		}, 500);
		$('#password').val('');
		e.preventDefault();
	});

	$('.back').on('click', function(e) {
		$('ul.slide-container').animate({
			left: '-320px'
		}, 500);
		$('.time-table').remove();
		$('.step3 section #enter-auto').remove();
		e.preventDefault();
	});

	$('.form-selector li p').on('click', function() {
		$('.form-selector li form').removeClass('open');
		$(this).next('form').addClass('open').slideDown(3000);
	});


	// Trigger a click and hide keyboard when click go!

	$('.step1').keypress(function(e) {
	    if(e.keyCode == 13) {
	    	$('.button').trigger('click');
	        document.activeElement.blur();
	    }
	});

	$('#enter-manual').keypress(function(e) {
	    if(e.keyCode == 13) {
	    	$('.add-by-jobcode').trigger('click');
	        document.activeElement.blur();
	    }
	});

	// One click Auto tiem add

	function autoTimeAdd() {

		$('.add').on('click', function() {
			
			var $this = $(this),
				jobcode = $('td:first', $this.parent().prev()).text(),
				addedHours = $this.prev().text(),
				date = $this.closest('li').prev('h3').text();

			if (addedHours.length) {

				$.post('php/auto-insert.php', {date: date, jobcode: jobcode, hours: addedHours},
					function(data){
						$('.auto-message .update-message').css('opacity', '1').html(data).animate({'opacity': '0'}, 3500);
				});
				return false;
			}

		});

	}

})();