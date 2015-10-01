<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gallery_item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_item';
	protected $primaryKey = 'id_item';
	
	public static function GetByIDitem($id_item)
        {
            return SELF::where('id_item', '=', $id_item);
        }
}

?>