<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
App\Models\m_status as m_status,
App\Models\m_articles1 as m_art,
App\Models\m_cat as m_cat,
Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminArt extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
var $niceNames = array(
    	'txt_summ' => 'Summary',
		'txt_title' => 'Title',
		'txt_content' => 'Content');
		
var $rules = array(
'txt_summ' =>'required',
'txt_title' =>'required',
'txt_content' =>'required');	

var $rules_thumb = array('txt_thumb' =>'required|image|mimes:jpeg,jpg,bmp,png,gif|max:3000');	

var $code = array('3','4');
    public function addArt()
    {
		$page_title = "Add Article";
		$title = "Admin - Add Article";
		$button_name = "Create Article";
		$url = 'art/storeArt';
		
		//$status = m_status::lists('desc','code');
		
		 $status = m_status::wherein('code', $this->code)->lists('desc','code');
		
		 
		$myclass = new myclass;
		$cb_cat = $myclass->gen_cat();
		
		return view('backend.formart', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status,'cb_cat' =>$cb_cat]);
    }
	
	public function storeArt(Request $request)
    {
		
		$image = Input::file('txt_thumb');
		$thumb = '';	
			if ($image) 
			{
				$file = array('txt_thumb' => Input::file('txt_thumb'));
				
				$validator = Validator::make($file, $this->rules_thumb);	
				$validator->setAttributeNames(array('txt_thumb' => 'Thumbnail')); 
				
				if ($validator->fails()) 
				{
					 return redirect('art/addArt/')
                        ->withErrors($validator)
                        ->withInput();
				}
				
				
				$destinationPath = config('myconfig.upload_folder_images');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
				
				$thumb = $destinationPath.'/'.$fullname;
				
			}	
			
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('art/addArt')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$art = new m_art;
		
		$art->title = Input::get('txt_title');
		$art->summary = Input::get('txt_summ');
		$art->content = Input::get('txt_content');
		$art->status = Input::get('cb_status');
		$art->catid = Input::get('cb_cat');
		$art->addby = Session::get('usrid');
		$art->id_gallery = Input::get('txt_galleryid');
		$art->tag = Input::get('txt_tag');
		$art->thumb = $thumb;
		$art->slug = str_slug(Input::get('txt_title'), '-');
		
		if ($art->save())
			{
				$request->session()->flash('success', 'Article was added successfully!');
				return Redirect::to('art/listArt');
			}
		
	}
	
	public function listArt()
    {
		$page_title = "List Articles";
		$title = "Admin - Articles";
		
		$art = m_art::all();
		
		return view('backend.listart', ['title' =>$title,'page_title' =>$page_title,'art'=>$art]);
		
	}
	
	public function delArt($artid)
	{
		$art = m_art::find($artid);

      	if($art)
      	{
      	   	$art->delete();
      		return Redirect::to('art/listArt')->with('success', 'Article succesfully deleted');
      	}
		
	}
	
	public function editArt($artid)
	{
		$art =  m_art::find($artid);
		$page_title = "Edit Article";

		$title = "Admin - Edit Article ";
		$button_name = "Update Article";
		$url = 'art/updateArt';
	
		$status = m_status::lists('desc','code');
		
		$myclass = new myclass;
		$cb_cat = $myclass->gen_cat();
	
		return view('backend.formart', ['title' =>$title,'page_title' =>$page_title
		,'button_name' =>$button_name,'url' =>$url,'status' =>$status,'cb_cat' =>$cb_cat,'art' =>$art]);
		
	}
	
	public function updateArt(Request $request)
	{
		$artid = Input::get('txt_artid');
		
		$image = Input::file('txt_thumb');
		$thumb = '';	
			if ($image) 
			{
				$file = array('txt_thumb' => Input::file('txt_thumb'));
				
				$validator = Validator::make($file, $this->rules_thumb);	
				$validator->setAttributeNames(array('txt_thumb' => 'Thumbnail')); 
				
				if ($validator->fails()) 
				{
					 return redirect('art/ediArt/'.$artid)
                        ->withErrors($validator)
                        ->withInput();
				}
				
				$destinationPath = config('myconfig.upload_folder_images');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
				
				$thumb = $destinationPath.'/'.$fullname;
				
				//Delete old file
				if(Input::has('txt_thumb_old'))
				{
					File::delete(Input::get('txt_thumb_old'));
				}
				
			}	
			
			
		
		$validator = Validator::make($request->all(), $this->rules);
		$validator->setAttributeNames($this->niceNames); 
		
		if ($validator->fails()) {
            return redirect('art/editArt')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		$art =  m_art::find($artid);
		
		$art->title = Input::get('txt_title');
		$art->summary = Input::get('txt_summ');
		$art->content = Input::get('txt_content');
		$art->status = Input::get('cb_status');
		$art->catid = Input::get('cb_cat');
		$art->chby = Session::get('usrid');
		$art->slug = str_slug(Input::get('txt_title'), '-');
		
		$art->id_gallery = Input::get('txt_galleryid');
		$art->tag = Input::get('txt_tag');
		
		if ($image) 
			{
				$art->thumb = $thumb;
			}
		
		
		if ($art->save())
			{
				return Redirect::to('art/listArt')->with('success', 'Article was updated successfully!');
			}
	}
	
}
?>