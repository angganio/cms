<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_status as m_status,
App\Models\m_cat as m_cat,
Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminCat extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
var $niceNames = array(
    	'txt_desc' => 'Description');
var $rules = array('txt_desc' => 'required');		

    public function addCat()
    {
		$page_title = "Add Categories";
		$title = "Admin - Add Categories";
		$button_name = "Create Category";
		$url = 'cat/storeCat';
		
		$status = m_status::lists('desc','code');
		
		$myclass = new myclass;
		$cb_parent = $myclass->gen_cat();
		
		return view('backend.formcat', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status,'cb_parent' =>$cb_parent]);
    }
	
	public function storeCat(Request $request)
    {
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('cat/addCat')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$cat = new m_cat;
		
		$cat->desc = Input::get('txt_desc');
		$cat->pid = Input::get('cb_parent');
		$cat->status = Input::get('cb_status');
		$cat->addby = Session::get('usrid');
		$cat->slug = str_slug(Input::get('txt_desc'), '-');
		
		
		if ($cat->save())
			{
				$request->session()->flash('success', 'Category was added successfully!');
				return Redirect::to('cat/listCat');
			}
		
	}
	
	public function listCat()
    {
		$page_title = "List Categories";
		$title = "Admin - List Categories";
		
		$cat = m_cat::all();
		
		return view('backend.listcat', ['title' =>$title,'page_title' =>$page_title,'cat'=>$cat]);
		
	}
	
	public function delCat($id)
	{
		$cat = m_cat::find($id);

      	if($cat)
      	{
      	   	$cat->delete();
      		return Redirect::to('cat/listCat')->with('success', 'Category succesfully deleted');
      	}
		
	}
	
	public function editCat($catid)
	{
		$cat =  m_cat::find($catid);
		$page_title = "Edit Category";
		$title = "Admin - Edit Category ID ".$catid;
		$button_name = "Update Category";
		$url = 'cat/updateCat';
	
		$status = m_status::lists('desc','code');
		
		$myclass = new myclass;
		$cb_parent = $myclass->gen_cat();
	
		return view('backend.formcat', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status,'cb_parent' =>$cb_parent,'cat' =>$cat]);
		
	}
	
	public function updateCat(Request $request)
	{
		$catid = Input::get('txt_catid');
		
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('cat/editCat/'.$catid)
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		$cat =  m_cat::find($catid);
		
		$cat->desc = Input::get('txt_desc');
		$cat->pid = Input::get('cb_parent');
		$cat->status = Input::get('cb_status');
		$cat->chby = Session::get('usrid');
		$cat->slug = str_slug(Input::get('txt_desc'), '-');
		
		if ($cat->save())
			{
				return Redirect::to('cat/listCat')->with('success', 'Category was updated successfully!');
			}
	}
	
}
?>