<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BangunanPeribadatanModel extends Model
{
	protected $table = 'bangunan_peribadatan_rbi';
	protected $guarded = ['id'];

	public function bangunanperibadatans($bbox, $zoom)
	{
		if ($zoom >= 13) {
			$data = $this->selectRaw('id, ST_AsGeoJSON(geom) as geom, remark')
			->where(function($query) use ($bbox) {
				$query->whereRaw('ST_Contains(st_makeenvelope(' . $bbox . ', 4326), geom)');
			})
			->limit(200)
			->get();
	
			return $data;
		} else {
			return [];
		}
	}
}
