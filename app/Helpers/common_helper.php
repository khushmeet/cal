<?php

/*
* This function make sure no unauthorised access is there
*/
function loginCheck()
{

    if(!isset($_SESSION['token'])) {
		
		header("Location:".base_url()."/logout");
		exit();
    
    }

}

/*
* This function make user goesnot goes to login / register page once loged in
*/

function isLoggedIn() 
{

	 if(isset($_SESSION['token'])) {
		
		header("Location:".base_url()."/main");
		exit();
    
    }

}

/*
* This function return json
*/
function returnJson($response)
{
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

}