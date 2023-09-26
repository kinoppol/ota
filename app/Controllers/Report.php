<?php

namespace App\Controllers;

class Report extends BaseController
{
	public function list()
	{
		helper('user');
		$data=array(
			'title'=>'รายงานผลการดำเนินงาน',
			'mainMenu'=>view('_menu'),
            'content'=>view('report'),
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
}