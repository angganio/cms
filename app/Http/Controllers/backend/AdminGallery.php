<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_status as m_status,
App\Models\m_gallery as m_gallery,
App\Models\gallery_item as gallery_item,
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
var $rules_image = array('txt_userfile'=>'required|image|mimes:jpeg,jpg,bmp,png,gif|max:3000');			
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
		$gallery->status = Input::get('cb_status');
		$gallery->slug = str_slug(Input::get('txt_name'), '-');
		
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
		$gallery = m_gallery::find($id_gallery);
		$gallery_item = gallery_item::where('id_gallery', $id_gallery)->get();
		
      	if($gallery)
      	{
				//Delete all item photo gallery
				foreach($gallery_item as $row):
				
				File::delete($row->foto);
				
				endforeach;
				
		}
			$deletedRows = gallery_item::where('id_gallery', $id_gallery)->delete();
			
      	   	$gallery->delete();
			
			return Redirect::to('gallery/listGallery')->with('success', 'Gallery succesfully deleted');	
		
	}
	
	public function editGallery($id_gallery)
	{
		$gallery =  m_gallery::find($id_gallery);
		$page_title = "Edit Gallery";
		$title = "Admin - Edit Gallery";
		$button_name = "Update Gallery";
		$url = 'gallery/updateGallery';
	
		$status = m_status::wherein('code', $this->code)->lists('desc','code');
	
		return view('backend.formgallery', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'gallery' =>$gallery,'status' =>$status]);
		
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
		$gallery->status = Input::get('cb_status');
		$gallery->chby = Session::get('usrid');
		$gallery->slug = str_slug(Input::get('txt_name'), '-');
		
		if ($gallery->save())
			{
				return Redirect::to('gallery/listGallery')->with('success', 'Gallery was updated successfully!');
			}
	}
	
	
	public function addPhoto($id_gallery)
    {
		$page_title = "List Gallery ID ".$id_gallery;
		$title = "Admin - List Gallery ID ".$id_gallery;
		$url = 'gallery/storePhoto/';
		$gallery_item = gallery_item::where('id_gallery', $id_gallery)->get();
		
		return view('backend.formphoto', ['title' =>$title,'page_title' =>$page_title,'gallery_item' =>$gallery_item,'url' =>$url]);
		
	}
	
	
	public function storePhoto(Request $request)
    {
		$image = Input::file('txt_userfile');
		$idgallery = Input::get('txt_idgallery');
		$usrpic = '';
			
				$validator = Validator::make($request->all(), $this->rules_image);	
				$validator->setAttributeNames(array('txt_userfile' => 'Photo')); 
				
				if ($validator->fails()) 
				{
					 return redirect('gallery/addPhoto/'.$idgallery)
                        ->withErrors($validator)
                        ->withInput();
				}
				
				$destinationPath = config('myconfig.upload_folder_gallery');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
				
				$usrpic = $destinationPath.'/'.$fullname;
			
		
		$photo = new gallery_item;
		
		$photo->caption = Input::get('txt_caption');
		$photo->id_gallery = $idgallery;
		$photo->addby = Session::get('usrid');
		$photo->foto = $usrpic;
		
		if ($photo->save())
			{
				$request->session()->flash('success', 'Photo was added successfully!');
				return Redirect::to('gallery/addPhoto/'.$idgallery);
			}
			
	}
	
	public function editPhoto($id_gallery,$id_item)
	{
		$photo =  gallery_item::find($id_item);
		$page_title = "Edit Photo With ID ".$id_item." In Gallery ID ".$id_gallery;
		$title = "Admin - Edit Photo With ID ".$id_item." In Gallery ID ".$id_gallery;
		$button_name = "Update Caption";
		$url = 'gallery/updatePhoto/';
	
		return view('backend.formphotoedit', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'photo' =>$photo]);
		
	}
	
	public function updatePhoto(Request $request)
	{
		$id_gallery = Input::get('txt_idgallery');
		$id_item = Input::get('txt_id_item');
	
		$photo =  gallery_item::find($id_item);
		
		$photo->caption = Input::get('txt_caption');
		$photo->chby = Session::get('usrid');

		
		if ($photo->save())
			{
				return Redirect::to('gallery/addPhoto/'.$id_gallery)->with('success', 'Photo was updated successfully!');
			}
	}
	
	
	public function delPhoto($id_gallery,$id_item)
	{
		$photo = gallery_item::find($id_item);
		
      	if($photo)
      	{
			File::delete($photo->foto);
      	   	$photo->delete();
      		return Redirect::to('gallery/addPhoto/'.$id_gallery)->with('success', 'Photo succesfully deleted');
      	}
		
	}
	
}
?>