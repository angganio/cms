<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_status as m_status,
App\Models\m_gallery as m_gallery,
Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminGallery extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
var $niceNames = array(
    	'txt_name' => 'Gallery Name');
		
var $rules = array('txt_name' => 'required');		
var $code = array('2','3');

    public function addGallery()
    {
		$page_title = "Add Gallery";
		$title = "Admin - Add Gallery";
		$button_name = "Create Gallery";
		$url = 'gallery/storeGallery';
		
		$status = m_status::wherein('code', $this->code)->lists('desc','code');
		 
		return view('backend.formgallery', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status]);
    }
	
	public function storeGallery(Request $request)
    {
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('gallery/addGallery')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$gallery = new m_gallery;
		
		$gallery->name = Input::get('txt_name');
		$gallery->addby = Session::get('usrid');
		
		
		if ($gallery->save())
			{
				$request->session()->flash('success', 'Gallery was added successfully!');
				return Redirect::to('gallery/listGallery');
			}
		
	}
	
	public function listGallery()
    {
		$page_title = "List Gallery";
		$title = "Admin - List Gallery";
		
		$gallery = m_gallery::all();
		
		return view('backend.listgallery', ['title' =>$title,'page_title' =>$page_title,'gallery' =>$gallery]);
		
	}
	
	public function delGallery($id_gallery)
	{
		$gallery = m_status::find($id_gallery);

      	if($gallery)
      	{
      	   	$gallery->delete();
      		return Redirect::to('gallery/listGallery')->with('success', 'Gallery succesfully deleted');
      	}
		
	}
	
	public function editGallery($id_gallery)
	{
		$gallery =  m_gallery::find($id_gallery);
		$page_title = "Edit Gallery";
		$title = "Admin - Edit Gallery";
		$button_name = "Update Gallery";
		$url = 'gallery/updateGallery';
	
		return view('backend.formgallery', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'gallery' =>$gallery]);
		
	}
	
	public function updateGallery(Request $request)
	{
		$id_gallery = Input::get('txt_idgallery');
		
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('gallery/editGallery/'.$id_gallery)
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		$gallery =  m_gallery::find($id_gallery);
		
		$gallery->name = Input::get('txt_name');
		$gallery->chby = Session::get('usrid');

		
		if ($gallery->save())
			{
				return Redirect::to('gallery/listGallery')->with('success', 'Gallery was updated successfully!');
			}
	}
	
}
?>