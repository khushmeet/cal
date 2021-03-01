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
		if($('body .load-tasks').length > 0 ){
			
			app.tasks.loadTasks();
			
		}

	},

    events : function () {


    	//add task button clicked 
		$('body').on('click','#add-task',function(){

			var title = $('#myDIV input[name="title"]').val();

			var start_time = $('#myDIV input[name="start_time"]').val();
			
			if(title.length >= 4 && start_time.length > 0  )
			{
				app.tasks.createTask(title, start_time);
			}else {
				alert('Tile should be min 4 character and date should be valid');
			}

		});

		// edit task 
		$('body').on('click','.save-task',function(){

			var title = $('.modal-data input[name="title"]').val();

			var start_time = $('.modal-data input[name="start_time"]').val();

			var taskid = $('.modal-data input[name="id"]').val();
			
			if(title.length >= 4 && start_time.length > 0  )
			{
				app.tasks.editTask(title, start_time, taskid);
			}else {
				alert('Tile should be min 4 character and date should be valid');
			}

		});


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

				 	$('.errormsg').append('<div class="alert alert-success">' + response.messages.Success + '</div>');

				 	$("#name, #email, #password").val("");

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
	
	tasks : {

		// load all tasks
		loadTasks : function() {

			app.ajaxHtml('alltask', '', '', function (response) {
					
					console.log(response.html);
					$('.load-tasks').html(response.html);
			});

			app.loader.remove();
		},

		createTask : function(title, start_time) {

			app.loader.add();

			app.ajaxHtml('addtask', {title:title, start_time:start_time }, '', function (response) {
					//console.log(response.response);
				if(response.response.messages) {

					if(response.response.status == 200) {

						app.tasks.loadTasks();
					}

					if(response.response.status != 200 ) {

						$.each(response.response.messages, function( index, value ) {

  							alert(value);
					
						});

					}
	
				}	
			});
			app.loader.remove();
			

		},

		// get single task
		loadTask : function(taskid) {

			app.loader.add();

			$('div').remove('.modal-data');

			app.ajaxHtml('showtask', {taskid: taskid },'' ,function (response) {
						//console.log(response)
					$('.modal-body').append(response.html);
			});

			app.loader.remove();
		},

		// delete task
		deleteTask : function(id) {

				if(confirm("Are you sure you want to delete this task?")){
					app.ajaxHtml('deletetask', {taskid:id},'' ,function (response) {
						app.tasks.loadTasks();
					});

					// load task
				}
		},

		// edit task
		editTask : function(title, start_time, taskid) {

			app.loader.add();
			
			$('div').remove( ".alert" );

			app.ajaxHtml('edittask', {title:title, start_time:start_time, taskid:taskid  },'' ,function (response) {
					
				if(response.response.messages) {

						$.each(response.response.messages, function( index, value ) {

  							$('.msg').append('<div class="alert alert-primary" role="alert">' + value + '</div>');	
					
						});

						app.tasks.loadTasks();
					}

			});

			app.loader.remove();
		},


	},

	urlValue : {
		getLastPart : function() {
			var url      = window.location.href;  
			return  url.substring(url.lastIndexOf('/') + 1);
		},
	},

	loader: {
		remove : function() {
			$('div').remove('.loading');
		},

		add: function() {
			$('.loader-wrapper').append('<div class="loading">Loading&#8230;</div>');
		}
	},
	
	
}
