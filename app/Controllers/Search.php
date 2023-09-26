<?php

namespace App\Controllers;

class Search extends BaseController
{
	public function result()
	{
		helper('user');
		$data=array(
			'title'=>'ผลลัพธ์การค้นหา',
			'systemName'=>'งานความร่วมมือ',
			'mainMenu'=>view('_menu'),
		);
		return view('_main',$data);
	}
}
