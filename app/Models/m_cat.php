<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_cat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_cat';
	protected $primaryKey = 'catid';
	
	public static function GetByCatID($catid)
        {
            return SELF::where('catid', '=', $catid);
        }
}

?>