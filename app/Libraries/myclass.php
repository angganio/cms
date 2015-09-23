<?php 

namespace App\Libraries;
use DB;
class myclass {

var $cat = array();
	
/* -------------------------- Create category dropdown tree -------------------------------- */
public function gen_cat_tree($id,$level)
{			
				$query = DB::select( DB::raw("SELECT * FROM m_cat WHERE pid = '$id' ORDER BY catid, pid ASC") );
				foreach($query as $row): 
				
					$val = '';
					$desc = '';
				
					$val = $row->catid;

					for ($i = 0; $i < ($level-1); $i++) $desc .= '&nbsp;&nbsp;&nbsp;&nbsp;';
					$desc .= '|___'.$row->desc;
					$this->cat[$val] = $desc; 
				
				$this->gen_cat_tree($row->catid,$level+1);
     			endforeach;   
}

function gen_cat()
{
	$this->cat['0']=  'Parent';
	$query = DB::select( DB::raw("SELECT * FROM m_cat WHERE pid =0 ORDER BY catid, pid ASC") );
	foreach($query as $row):
			$this->cat[$row->catid] =  $row->desc;
			$this->gen_cat_tree($row->catid,1);
	endforeach;
	return $this->cat;      
}
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>