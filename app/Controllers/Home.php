<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		//$this->load->helper('url');
		return view('welcome_message');
	}
	public function dashboard()
	{

		$data=array(
			'title'=>'ภาพรวม',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>'ภาพรวม',
		);
		return view('_main',$data);
	}
}
