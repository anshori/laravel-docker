<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatasKabupatenModel extends Model
{
	protected $table = 'batas_kabupaten_bps_2020';
	protected $guarded = ['id'];

	public function bataskabupatens($bbox, $zoom)
	{
		if ($zoom >= 9) {
			$data = $this->selectRaw('id, ST_AsGeoJSON(geom) as geom, wadmkk, wadmpr, ST_Area(geom, true) as area')
			->where(function($query) use ($bbox) {
				$query->whereRaw('ST_Contains(st_makeenvelope(' . $bbox . ', 4326), geom)')
					->orWhereRaw('ST_Overlaps(geom, st_makeenvelope(' . $bbox . ', 4326))');
			})
			->limit(250)
			->get();
	
			return $data;
		} else {
			return [];
		}
	}
}
