$(document).ready(function () {
    app.init();
    app.loader.remove();
});

var app = {
	
    init : function () {

        // to be triggred as per matched class per page
		this.pageLoaders();

        // Button click, submit etc events
        this.events();	
	},

	ajaxHtml : function (url, data, btnId ,onSuccess) {
        $.ajax({
            type: "POST",
            url:  url,
            data: data,
			dataType : 'json',
            beforeSend: function(){
				$(".btnId").attr("disabled", true); 	
            },
			complete: function(){
			  $(".btnId").attr("disabled", false); 
            },
            success: function(response){
				
                onSuccess(response);
            }
        });
    },

	pageLoaders : function() {
		
		//************Write all section Load functions here**********************//
		
		// check if certain class exist
		if($('body.load-task').length > 0 ){
			app.loader.add();
			var value = app.urlValue.getLastPart();
			$( ".main-content" ).load( "/data/productContent/"+value, function() {
				app.loader.remove();
				$(".modal-preload-parts").click();
			});
		}

	},

    events : function () {

		//login button clicked 
		$('body').on('click','#login-button',function(){

			var email = $('#login input[name="email"]').val();

			var password = $('#login input[name="password"]').val();
			
			$('div').remove( ".alert" );
			
			app.loader.add();

			app.ajaxHtml('login', {email: email, password: password },'login-button' ,function (response) {

				 if(response.status == 200) {

				 	window.location.href = "main";

				 } else if(response.messages) {

				 	$.each(response.messages, function( index, value ) {

  						$('.errormsg').append('<div class="alert alert-danger">' + value + '</div>');
					
					});

				 }else {
				 	
				 	$('.errormsg').append('<div class="alert alert-danger">' + response.message + '</div>');	
				 
				 }
			});
            
            app.loader.remove();

		});

        // register button clicked
		$('body').on('click','#register-button',function(){

			var email = $('#register input[name="email"]').val();

			var password = $('#register input[name="password"]').val();

			var name = $('#register input[name="name"]').val();
			
			$('div').remove( ".alert" );
			
			app.ajaxHtml('register', {email: email, password: password, name:name },'register-button' ,function (response) {
				
				if(response.status == 200) {

				 	$('.errormsg').append('<div class="alert alert-success">' + response.message + '</div>');

				 }else if(response.messages) {

				 	$.each(response.messages, function( index, value ) {

  						$('.errormsg').append('<div class="alert alert-danger">' + value + '</div>');
					
					});

				 }else {
                    
				 	$('.errormsg').append('<div class="alert alert-danger">' + response.message + '</div>');	
				 
				 }
			});
            
		});
		
		
    },
	
	urlValue : {
		getLastPart : function(){
			var url      = window.location.href;  
			return  url.substring(url.lastIndexOf('/') + 1);
		}
	},
	loader: {
		remove : function(){
			$('div').remove('.loading');
		},
		add: function() {
			$('.loader-wrapper').append('<div class="loading">Loading&#8230;</div>');
		}
	},
	
	
}
