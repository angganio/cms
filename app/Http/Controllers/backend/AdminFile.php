<?php

namespace App\Http\Controllers\backend;


use App\User;
use App\Http\Controllers\Controller;

use Validator,
Illuminate\Http\Request,
Input,
Hash,
Redirect,
Session,
File,
Auth,
App\Libraries\myclass;

class AdminFile extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
	var $rules_image = array('txt_userfile'=>'required|image|mimes:jpeg,jpg,bmp,png,gif|max:3000');	
	 
	public function storeFile(Request $request)
    {
		$image = Input::file('txt_userfile');
			
				$validator = Validator::make($request->all(), $this->rules_image);	
				$validator->setAttributeNames(array('txt_userfile' => 'File')); 
				
				if ($validator->fails()) 
				{
					 return redirect('upload/listFile/')
                        ->withErrors($validator)
                        ->withInput();
				}
				
				$destinationPath = config('myconfig.upload_folder_images');
				$filename = $image->getClientOriginalName();
			  	$fullname = date('dmYHis').'.'.$filename;
				$green = $image->move($destinationPath, $fullname);
			
				$request->session()->flash('success', 'File was added successfully!');
				return Redirect::to('upload/listFile/');

		
	}
	
	public function listFile()
    {
		$page_title = "List File";
		$title = "Admin - File";
		$directory = config('myconfig.upload_folder_images');
		$files = File::allFiles($directory);
		
		foreach($files as $path)
		{
   		 $manuals[] = pathinfo($path);
		}

		$url = 'upload/storeFile/';
		//dd($manuals);
		
		return view('backend.formupload', ['title' =>$title,'page_title' =>$page_title,'files' =>$manuals,'url' =>$url]);
		
	}
	
	
	public function delFile($files)
	{
		File::delete(config('myconfig.upload_folder_images').'/'.$files);
		return Redirect::to('upload/listFile')->with('success', 'File was deleted successfully!');
	}
	
	
	
}
?>