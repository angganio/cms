<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_articles1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_articles';
	protected $primaryKey = 'id_artikel';
	
	public static function GetByArtID($id_artikel)
        {
            return SELF::where('id_artikel', '=', $id_artikel);
        }
}

?>