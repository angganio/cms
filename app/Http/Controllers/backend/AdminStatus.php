<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_status as m_status,
Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminStatus extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
var $niceNames = array(
    	'txt_desc' => 'Description',
		'txt_code' => 'Code');
		
var $rules = array('txt_code' => 'required|unique:m_status,code','txt_desc' => 'required');		

    public function addStatus()
    {
		$page_title = "Add Status";
		$title = "Admin - Add Status";
		$button_name = "Create Status";
		$url = 'status/storeStatus';
		
		return view('backend.formstatus', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url]);
    }
	
	public function storeStatus(Request $request)
    {
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('status/addStatus')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$status = new m_status;
		
		$status->desc = Input::get('txt_desc');
		$status->addby = Session::get('usrid');
		
		
		if ($status->save())
			{
				$request->session()->flash('success', 'Status was added successfully!');
				return Redirect::to('status/listStatus');
			}
		
	}
	
	public function listStatus()
    {
		$page_title = "List Status";
		$title = "Admin - List Status";
		
		$status = m_status::all();
		
		return view('backend.liststatus', ['title' =>$title,'page_title' =>$page_title,'status' =>$status]);
		
	}
	
	public function delStatus($code)
	{
		$status = m_status::find($code);

      	if($status)
      	{
      	   	$status->delete();
      		return Redirect::to('status/listStatus')->with('success', 'Status succesfully deleted');
      	}
		
	}
	
	public function editStatus($code)
	{
		$status =  m_status::find($code);
		$page_title = "Edit Status";
		$title = "Admin - Edit Status Code ".$code;
		$button_name = "Update Status";
		$url = 'status/updateStatus';
	
		return view('backend.formstatus', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status]);
		
	}
	
	public function updateStatus(Request $request)
	{
		$code = Input::get('txt_code');
		
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('status/editStatus/'.$code)
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		$status =  m_status::find($code);
		
		$status->desc = Input::get('txt_desc');
		$status->color = Input::get('txt_color');
		$status->chby = Session::get('usrid');

		
		if ($status->save())
			{
				return Redirect::to('status/listStatus')->with('success', 'Status was updated successfully!');
			}
	}
	
}
?>