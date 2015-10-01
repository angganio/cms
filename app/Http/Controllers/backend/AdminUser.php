<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_user as m_user,
App\Models\m_user_grp as m_user_grp,
App\Models\m_status as m_status,
Input,
Hash,
Redirect,
Session,
File,
Auth;

class AdminUser extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
var $niceNames = array(
    	'txt_userid' => 'User ID',
		'txt_dispnam' => 'Display Name',
		'txt_email' => 'Email',
		'txt_pass' => 'Password',
		'txt_pass_conf' => 'Confirm Password');

var $rules = array('txt_usrpic'=>'required|image|mimes:jpeg,jpg,bmp,png,gif|max:3000');		

    public function addUser()
    {
		$page_title = "Add User";
		$title = "Admin - Add User";
		$button_name = "Create User";
		
		$url = 'user/storeUser';
		$usergrp = m_user_grp::lists('grp_desc','id_grp');
		$status = m_status::lists('desc','code');
		
		return view('backend.formuser', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'usergrp' =>$usergrp,'status' =>$status]);
    }
	
	public function storeUser(Request $request)
    {
		$image = Input::file('txt_usrpic');
		$usrpic = '';	
			if ($image) 
			{
				$file = array('txt_usrpic' => Input::file('txt_usrpic'));
				$validator = Validator::make($file, $this->rules);	
				$validator->setAttributeNames(array('txt_usrpic' => 'Display Picture')); 
				
				if ($validator->fails()) 
				{
					 return redirect('user/addUser')
                        ->withErrors($validator)
                        ->withInput();
				}
				
				$destinationPath = config('myconfig.upload_folder_users');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
				
				$usrpic = $destinationPath.'/'.$fullname;
				
			}	
			
		$validator = Validator::make($request->all(), [
            'txt_userid' => 'required|unique:m_user,usrid',
            'txt_dispnam' => 'required',
			'txt_email' => 'required|email|unique:m_user,email',
			'txt_pass' => 'required|min:6',
			'txt_pass_conf' => 'required|same:txt_pass',
        ]);
		$validator->setAttributeNames($this->niceNames); 

        if ($validator->fails()) {
            return redirect('user/addUser')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$users = new m_user;
		
		$users->usrid = Input::get('txt_userid');
		$users->dispname = Input::get('txt_dispnam');
		$users->email = Input::get('txt_email');
		$users->password = Hash::make(Input::get('txt_pass'));
		$users->status = Input::get('cb_status');
		$users->id_grp = Input::get('cb_usergrp');
		$users->addby = Session::get('usrid');
		$users->foto = $usrpic;
		
		if ($users->save())
			{
				$request->session()->flash('success', 'User was added successfully!');
				return Redirect::to('user');
			}
			
	}
	
	public function listUser(Request $request)
    {
		$page_title = "List User";
		$title = "Admin - List User";
		
		if ($request->isMethod('post'))
		{
			if(Input::get('txt_cari') != '')
			{
				Session::put('txt_cari_user', Input::get('txt_cari'));
				$users =  m_user::where('dispname', 'LIKE', '%'.Input::get('txt_cari').'%')->paginate(config('myconfig.paging_num'));
			}
			else
			{
				Session::forget('txt_cari_user');
				//$users = m_user::all();
				$users = m_user::where('usrid', '<>', Session::get('usrid'))->orderBy('usrid','ASC')->paginate(config('myconfig.paging_num'));
				//$users = m_user::orderBy('usrid','desc')->paginate(config('myconfig.paging_num'));
			}
			
		}
		else
		{
			if (Session::has('txt_cari_user'))
			{
				$users =  m_user::where('dispname', 'LIKE', '%'.Session::get('txt_cari_user').'%')->paginate(config('myconfig.paging_num'));
			}
			else
			{
				//$users = m_user::all();
				$users = m_user::where('usrid', '<>', Session::get('usrid'))->orderBy('usrid','ASC')->paginate(config('myconfig.paging_num'));
				//$users = m_user::orderBy('usrid','desc')->paginate(config('myconfig.paging_num'));
				
			}
			
		}
		
		$users->setPath('listUser');
		
		return view('backend.listuser', ['title' =>$title,'page_title' =>$page_title,'users' =>$users]);
		
	}
	
	public function editUser($usrid)
	{
		//$users =  m_user::GetByUserID($usrid)->first();
		$users =  m_user::find($usrid);
		$page_title = "Edit User";
		$title = "Admin - Edit User ".$usrid;
		$button_name = "Update User";
		$url = 'user/updateUser';
	
		$usergrp = m_user_grp::lists('grp_desc','id_grp');
		$status = m_status::lists('desc','code');
	
		return view('backend.formuser', ['title' =>$title,'page_title' =>$page_title,'button_name' =>$button_name,'users' =>$users,'url' =>$url,'usergrp' =>$usergrp,'status' =>$status]);
	}
	
	public function updateUser(Request $request)
	{
		$usrid = Input::get('txt_userid');
		
		$image = Input::file('txt_usrpic');
		$usrpic = '';	
			if ($image) 
			{
				$file = array('txt_usrpic' => Input::file('txt_usrpic'));
				
				$validator = Validator::make($file, $this->rules);	
				$validator->setAttributeNames(array('txt_usrpic' => 'Display Picture')); 
				
				if ($validator->fails()) 
				{
					 return redirect('user/editUser/'.$usrid)
                        ->withErrors($validator)
                        ->withInput();
				}
				
				//Delete old file
				if(Input::has('txt_usrpic_old'))
				{
					File::delete(Input::get('txt_usrpic_old'));
				}
				
				$destinationPath = config('myconfig.upload_folder_users');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
				
				$usrpic = $destinationPath.'/'.$fullname;
				
			}	
		
		if(Input::has('txt_pass'))
			{
				$validator = Validator::make($request->all(), [
				'txt_userid' => 'required',
				'txt_dispnam' => 'required',
				'txt_email' => 'required|email',
				'txt_pass' => 'required|min:6',
				'txt_pass_conf' => 'required|same:txt_pass',
				]);
			}
		else
			{
				$validator = Validator::make($request->all(), [
				'txt_userid' => 'required',
				'txt_dispnam' => 'required',
				'txt_email' => 'required|email',
				]);
				
			}
		
		$validator->setAttributeNames($this->niceNames); 

        if ($validator->fails()) {
            return redirect('user/editUser/'.Input::get('txt_userid'))
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$usrid = Input::get('txt_userid');
		$users =  m_user::GetByUserID($usrid)->first();

		$users->dispname = Input::get('txt_dispnam');
		$users->email = Input::get('txt_email');
		if(Input::has('txt_pass'))
			{
				$users->password = Hash::make(Input::get('txt_pass'));
			}
		$users->status = Input::get('cb_status');
		$users->id_grp = Input::get('cb_usergrp');
		$users->chby = Session::get('usrid');
		if ($image) 
			{
				$users->foto = $usrpic;
			}
		if ($users->save())
			{
				$request->session()->flash('success', 'User was updated successfully!');
				return Redirect::to('user/editUser/'.$usrid);
			}
		
	}
	
	 public function loginUser()
    {
		return view('backend.formlogin');
    }
	
	 public function authUser(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'txt_userid' => 'required',
			'txt_pass' => 'required',
        ]);
		$validator->setAttributeNames($this->niceNames); 

        if ($validator->fails()) {
            return redirect('user/loginUser')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$user = array(
		'usrid' => Input::get('txt_userid'),
		'password' => Input::get('txt_pass'),
		'status' => 1
		);
		
		if (Auth::attempt($user))
		{
			//Fill session data
			$usrid =  Input::get('txt_userid');
		
			$users =  m_user::find($usrid);
			
			Session::put('usrid',$usrid );
			Session::put('usrfoto',$users->foto);
			
			return Redirect::to('/dashboard/');
		}
		return Redirect::to('user/loginUser')->with('error','Could not log in, please check your username and password');
		
    }
	
	
	 public function logoutUser(Request $request)
    {
		$request->session()->flush();
		Auth::logout();
		return Redirect::to('user/loginUser')->with('success', 'Succesfully logout');
    }
	
	 public function forgetPass()
    {
		return view('backend.formforgotpass');
    }
	
	public function sendPass(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'txt_email' => 'required|email',
        ]);
		$validator->setAttributeNames($this->niceNames); 

        if ($validator->fails()) {
            return redirect('user/forgetPass')
                        ->withErrors($validator)
                        ->withInput();
        }
    }
}
?>