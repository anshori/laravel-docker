<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class JalanModel extends Model
{
	protected $table = 'ruas_jalan';
	protected $guarded = ['id'];

	public function jalans($bbox, $zoom)
	{
		$data = $this->selectRaw('id, ST_AsGeoJSON(geom) as geom, remark, fcode, lcode, ST_Length(geom, true) as length')
		->where('minzoom', '<=', $zoom)
		->where(function($query) use ($bbox) {
			$query->whereRaw('ST_Contains(st_makeenvelope(' . $bbox . ', 4326), geom)')
				->orWhereRaw('ST_Crosses(geom, st_makeenvelope(' . $bbox . ', 4326))');
		})
		->orderBy('minzoom', 'asc')
		->orderBy(DB::raw('ST_Length(geom, true)'), 'desc')
		->limit(250)
		->get();

		return $data;
	}
}
