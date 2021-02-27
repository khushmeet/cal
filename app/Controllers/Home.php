<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('index');
	}


	public function main($i=null)
	{
		echo $i;
		echo "string";
	}


}
