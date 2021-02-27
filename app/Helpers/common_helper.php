<?php


function loginCheck()
{

    if(!isset($_SESSION['token'])   ) {
		
		header("Location:".base_url()."/logout");
		exit();
    
    }

}

function returnJson($response)
{
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

}