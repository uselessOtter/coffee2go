var feedback = (function(){
	return{
		init: function(){
			$('.openFeedback').on('click', function(){
				feedback.showHideWindow();
			});

			$('.close_feedback').on('click', function(){
				feedback.showHideWindow();
			});
		},

		showHideWindow: function(){
			if($('.feedback-window').css('display') == 'none'){
				$('body').append('<div class="fade"></div>');
				feedback.loadForm();
				$('.fade').show();
				$('.feedback-window').show();
			}
			else{
				$('.feedback-window').hide();
				$('.fade').hide();
			}
		},

		loadForm: function(){
			$.ajax({
				type: 'GET',
				url: '/feedback',
				success: function(data){
					feedback.drawResult(data);
				}
			})
		},

		sendForm: function(formData){
			$.ajax({
				type: 'POST',
				url: '/feedback',
				data: formData,
				success: function(data){
					feedback.drawResult(data);
					if($('ul').hasClass('form-list')){
						feedback.displayErrorFields();
					}
				}
			});
		},

		drawResult: function(data){
			$('.fb-form').empty().append(data);
			$('.feedback-window').css('margin-left', -1 * ($('.feedback-window').width()/2) );

			$('.feedback-form-wrapper input[type=submit]').on('click', function(e){
				e.preventDefault();

				var formData = $('form').serialize();
				feedback.sendForm(formData);
			})
		},

		displayErrorFields: function(){
			$('input[type=text]').each(function(i){
                if($(this).parent().prev().children('.error').text() == "ОШИБКА ВВОДА"){
                    $(this).toggleClass('field_error');
                }
            })
		}
	}
})();
feedback.init();