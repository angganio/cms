<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_articles1 as m_articles,
App\Models\m_gallery as m_gallery,
App\Models\m_user as m_user,

Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminDashboard extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
	public function listDashboard()
    {
		$page_title = "Dashboard";
		$title = "Admin - Dashboard";
		
		$m_articles = m_articles::all();
		$count_art = number_format($m_articles->count());
		
		$m_user = m_user::all();
		$count_user = number_format($m_user->count());
		
		$m_gallery = m_gallery ::all();
		$count_gallery = number_format($m_gallery->count());
		
		return view('backend.formdashboard', ['title' =>$title,'page_title' =>$page_title,'count_art' =>$count_art,'count_user' =>$count_user,'count_gallery' =>$count_gallery]);
		
	}
	
	
	
}
?>