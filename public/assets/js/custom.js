$(document).ready(function () {
    app.init();
    app.loader.remove();
});

var app = {
	
    init : function () {
		this.pageLoaders();
        this.events();	
	},
	
	
	
	tooltip : function() {
		$('[data-toggle="tooltip"]').tooltip();	
	},
	
	
    formAsJson : function(formElement) {
        return formElement.serializeToJSON({
            // serialize the form using the Associative Arrays
            associativeArrays: true,
            // convert "true" and "false" to booleans true / false
            parseBooleans: true,
            parseFloat: {
                // the value can be a string or function
                condition: undefined,
                // auto detect NaN value and changes the value to zero
                nanToZero: true,
                // return the input value without commas
                getInputValue: function($input){
                    return $input.val().split(",").join("");
                }
            }
        });
    },
	
    getHtml : function (url, data, id, errorClass) {

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'html',
        }).done(function (response) {
            if (response.status) {
                $('#' + id).html(response.html);
            }
            elseif(response.status == false)
            {
                $('.' + errorClass).html(response.error);
            }
        }).fail(function () {
            $('#' + id).html('error');
        });
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
		if($('body.load-model').length > 0 ){
			app.loader.add();
			$('.loader-wrapper').css({"margin-top": "13%"});
			var value = app.urlValue.getLastPart();
			$( ".main-content" ).load( "/data/productContent/"+value, function() {
				app.loader.remove();
				$(".modal-preload-parts").click();
			});
		}
		
		if($('body.load-document').length > 0 ){
			app.loader.add();
			$('.loader-wrapper').css({"margin-top": "13%"});
			var value = app.urlValue.getLastPart();
			$( ".main-content" ).load( "/data/productDocument/"+value, function(){
				app.loader.remove();
			} );
		}
		
		if($('body.search input[name=s_term]').length > 0){
			var searchInput = $("input[name=s_term]").val();
			app.doSearch.getPartSearchResults(searchInput);
		}
		
		if($('body.search .search_results').length>0){
			$(window).scroll(function() {
				//alert();
				if($(window).scrollTop() == $(document).height() - $(window).height()) {
					//console.log(app.page);
					var start = app.page;
					app.doSearch.getPartSearchResultsAppend('baxi',start)
				}
			});
		}
		
		if($('body.load-parts').length > 0 ){
			app.loadPartsPage();
		}
		
		
		
	},

    events : function () {

		//login button
		$('body').on('click','#login-button',function(){

			var email = $('#login input[name="email"]').val();

			var password = $('#login input[name="password"]').val();
			
			$('div').remove( ".alert" );
			
			app.loader.add();

			app.ajaxHtml('login', {email: email, password: password },'login-button' ,function (response) {

				 if(response.status == 200) {

				 	window.location.href = "main";

				 }else if(response.messages) {

				 	$.each(response.messages, function( index, value ) {

  						$('.errormsg').append('<div class="alert alert-danger">' + value + '</div>');
					
					});

				 }else {
				 	
				 	$('.errormsg').append('<div class="alert alert-danger">' + response.message + '</div>');	
				 
				 }
			});
            
            app.loader.remove();

		});

		$('body').on('click','#register-button',function(){

			var email = $('#register input[name="email"]').val();

			var password = $('#register input[name="password"]').val();

			var name = $('#register input[name="name"]').val();
			
			$('div').remove( ".alert" );
			
			app.ajaxHtml('http://localhost/cal/public/api/register', {email: email, password: password, name:name },'register-button' ,function (response) {
				console.log(response);
				 if(response.status == 200) {

				 	window.location.href = "main";

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


    swals : {

        getStoreInfo : function(branchId){
            var branchId = branchId;
            app.ajaxHtml('/BranchFinder/store/'+branchId, {branchcode: branchId, ajaxreq: 'yes' },'#store-data' ,function (response) {
              //   document.getElementById("content").innerHTML = response.html;
  //   document.title = response.pageTitle;

        var urlPath = '/branch-finder/branch/store-'+branchId;
         window.history.pushState({"html":response.html,"pageTitle":response.title},"", urlPath);

                $('#store-data').html(response);

            });
        },

        getStoreNearBy : function(position){
            var position = position;
            app.ajaxHtml('/BranchFinder/nearestBranches', {position: position },'#store-data' ,function (response) {
                $('#store-data').html(response);
            });
            
        },

        getLocations : function(location_value){
            var location = location_value;
            app.ajaxHtml('/PostCode/getLocations', {location: location },'#store-data' ,function (response) {
                gmap.latlng = response;
            });
        },


        signinup : function (error) {
            var errorMsg = '';
            if (error) {
                errorMsg = '<div class="alert alert-danger">' + error + '</div>';
            }
            app.getSwalHtml('/login/signInUp', {email: ''}, function (response) {
                swal({
                    title: 'Please Enter Your Email',
                    html: '<div id="sign-in-up">' + response.html + errorMsg + '</div>',
                    confirmButtonText: 'Next',
                    showConfirmButton: true,
                    showCancelButton: true,
                    closeOnConfirm: false,
                    allowOutsideClick: false,
                }, function () {
                    swal.disableButtons();
                    app.swals.checkEmail();
                });
            });
        },

        checkEmail : function () {
            var email = $('#sign-in-up input[name="email"]').val();
            app.getSwalHtml('/login/emailCheck', {email: email}, function (response) {
                if (response.status == "new_user") {
                    app.swals.registration({email: email});
                } else if (response.status == "existing_user") {
                    app.swals.login({email: email});
                } else if (response.status == "invalid_email") {
                    app.swals.signinup(response.msg);
                }
            });
        },

        login : function (data, error) {
            var errorMsg = '';
            if (error) {
                errorMsg = '<div class="alert alert-danger">' + error + '</div>';
            }
            app.getSwalHtml('/login/login', data, function(response) {
                swal({
                    title: 'Sign In',
                    html: '<div id="sign-in-up">' + response.html + errorMsg +'</div>',
                    confirmButtonText: 'Sign In',
                    showCancelButton: true,
                    closeOnConfirm: false,
                    allowOutsideClick: false,
                }, function () {
                    var email = $('#sign-in-up input[name="email"]').val();
                    var password = $('#sign-in-up input[name="password"]').val();
                    app.swals.loginConfirm({email: email, password: password});
                });
            });
        },

        loginConfirm : function(data) {
            app.getSwalHtml('/login/loginConfirm', data, function(response) {
                if(response.status== "password_required") {
                    app.swals.login(data,response.msg);
                }
                else if(response.status == "invalid_password" ) {
                    app.swals.login(data,response.msg);
                }
                else if(response.status == "verify_email" ) {
                    app.swals.login(data,response.msg);
                }
                else if(response.status == "status_inactive" ) {
                    app.swals.login(data,response.msg);
                }
                else if(response.status == "active_user" )
                {
                    location.reload();
                }
                else
                {
                    app.swals.login(data,response.msg);
                }
            });
        },

        registration : function (data) {
            app.getSwalHtml('/login/registration', data, function(response) {
                swal({
                    title: 'Registration',
                    html: '<div id="sign-in-up">' + response.html  + '</div>',
                    confirmButtonText: 'Register',
                    showCancelButton: true,
                    closeOnConfirm: false,
                    allowOutsideClick: false,
                }, function () {
                    var data = app.formAsJson($("#registration_form"));
                    app.swals.registrationValidate(data);
                });
            });
        },

        registrationValidate : function(data) {
            app.getSwalHtml('/login/registrationValidate', {data:data}, function(response) {
                if(response.status) {
                    app.swals.registrationConfirm();
                }
                else {
                    swal({
                        title: 'Registration',
                        html: '<div id="sign-in-up">' + response.html  + '</div>',
                        confirmButtonText: 'Register',
                        showCancelButton: true,
                        closeOnConfirm: false,
                        allowOutsideClick: false,
                    }, function () {
                        var data = app.formAsJson($("#registration_form"));
                        app.swals.registrationValidate(data);
                    });
                }
            });
        },

        Confirm : function (message) {
			
			swal({
				type: 'success',
                text:  message,
                allowOutsideClick: false,
            });
        },

        info : function (message) {
			
			swal({
				type: 'info',
                text:  message,
                allowOutsideClick: false,
            });
        },

        warning : function (message) {
			
			swal({
				type: 'warning',
                text:  message,
                allowOutsideClick: false,
            });
        },

        forgotPassword : function(error) {
            var errorMsg = '';
			if (error) {
                errorMsg = '<div class="alert alert-danger">' + error + '</div>';
            }
			app.getSwalHtml('/forgotPassword', {email: ''}, function (response) {
                swal({
                    title: 'Forgot Password',
                    html: 'Please Enter Your Email Address<br><div id="sign-in-up">' + response.html + errorMsg + '</div>',
                    confirmButtonText: 'Reset',
                    showConfirmButton: true,
                    showCancelButton: true,
					confirmButtonColor: '#33ff33',
					cancelButtonColor: '#de1a12',
                    closeOnConfirm: false,
                    allowOutsideClick: false,
                }, function () {
                    //swal.disableButtons();
                    var email = $('#sign-in-up input[name="email"]').val();
					app.getSwalHtml('/forgotPasswordEmailSend', {email: email},function(response){
						if(!response.error) {
							// show forgot pwd with error
							app.swals.Confirm(response.message);
						}else{
							// show forgot password with try again
							swal.enableButtons();	
							app.swals.forgotPassword(response.message);
						}
					});
                });
            });
        },
		
		
		login : function (data, error) {
            var errorMsg = '';
            if (error) {
                errorMsg = '<div class="alert alert-danger">' + error + '</div>';
            }
            app.getSwalHtml('/login/login', data, function(response) {
                swal({
                    title: 'Sign In',
                    html: '<div id="sign-in-up">' + response.html + errorMsg +'</div>',
                    confirmButtonText: 'Sign In',
                    showCancelButton: true,
                    closeOnConfirm: false,
                    allowOutsideClick: false,
                }, function () {
                    var email = $('#sign-in-up input[name="email"]').val();
                    var password = $('#sign-in-up input[name="password"]').val();
                    app.swals.loginConfirm({email: email, password: password});
                });
            });
        },
		
		sessionExpired : function(){//return;
			swal({
					type: 'error',
                    title: 'Session Expired',
                    allowOutsideClick: false,
					showConfirmButton: false, 
                	html: 'You need to sign in again to access Spares Directory<br> <div class="user-choise"><a href="" onclick="location.reload();"  class="btn btn-danger ">Okay</a> </div>',
					
            });
			// if user doesnt click on okay automatically logout
			setTimeout(function(){location.reload() }, 5000);
		}

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
