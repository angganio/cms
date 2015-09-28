<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_gallery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_gallery';
	protected $primaryKey = 'id_gallery';
	
	public static function GetByGallID($id_gallery)
        {
            return SELF::where('id_gallery', '=', $id_gallery);
        }
}

?>