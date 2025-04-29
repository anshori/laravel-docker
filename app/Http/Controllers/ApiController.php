<?php

namespace App\Http\Controllers;

use App\Models\JalanModel;
use Illuminate\Http\Request;
use App\Models\BatasDesaModel;
use App\Models\BatasKabupatenModel;
use App\Models\BatasKecamatanModel;
use App\Models\BangunanPeribadatanModel;

class ApiController extends Controller
{
	public function __construct()
	{
		$this->jalan = new JalanModel();
		$this->batasdesa = new BatasDesaModel();
		$this->bataskecamatan = new BatasKecamatanModel();
		$this->bataskabupaten = new BatasKabupatenModel();
		$this->bangunanperibadatan = new BangunanPeribadatanModel();
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$bbox = $request->query('bbox');
		$zoom = $request->query('zoom');
		$jalans = $this->jalan->jalans($bbox, $zoom);

		$feature = array();

		foreach ($jalans as $data) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($data->geom),
				'properties' => [
					'remark' => $data->remark,
					'lcode' => $data->lcode,
					'fcode' => $data->fcode,
					'length' => round($data->length, 2),
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function batas_desa(Request $request)
	{
		$bbox = $request->query('bbox');
		$zoom = $request->query('zoom');
		$batasdesas = $this->batasdesa->batasdesas($bbox, $zoom);

		$feature = array();

		foreach ($batasdesas as $data) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($data->geom),
				'properties' => [
					'wadmkd' => $data->wadmkd,
					'wadmkc' => $data->wadmkc,
					'wadmkk' => $data->wadmkk,
					'wadmpr' => $data->wadmpr,
					'area' => round($data->area, 2),
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function batas_kecamatan(Request $request)
	{
		$bbox = $request->query('bbox');
		$zoom = $request->query('zoom');
		$bataskecamatans = $this->bataskecamatan->bataskecamatans($bbox, $zoom);

		$feature = array();

		foreach ($bataskecamatans as $data) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($data->geom),
				'properties' => [
					'wadmkc' => $data->wadmkc,
					'wadmkk' => $data->wadmkk,
					'wadmpr' => $data->wadmpr,
					'area' => round($data->area, 2),
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function batas_kabupaten(Request $request)
	{
		$bbox = $request->query('bbox');
		$zoom = $request->query('zoom');
		$bataskabupatens = $this->bataskabupaten->bataskabupatens($bbox, $zoom);

		$feature = array();

		foreach ($bataskabupatens as $data) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($data->geom),
				'properties' => [
					'wadmkk' => $data->wadmkk,
					'wadmpr' => $data->wadmpr,
					'area' => round($data->area, 2),
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	public function bangunan_peribadatan(Request $request)
	{
		$bbox = $request->query('bbox');
		$zoom = $request->query('zoom');
		$bangunanperibadatans = $this->bangunanperibadatan->bangunanperibadatans($bbox, $zoom);

		$feature = array();

		foreach ($bangunanperibadatans as $data) {
			$feature[] = [
				'type' => 'Feature',
				'geometry' => json_decode($data->geom),
				'properties' => [
					'remark' => $data->remark,
				]
			];
		}

		return response()->json([
			'type' => 'FeatureCollection',
			'features' => $feature,
		])->setEncodingOptions(JSON_NUMERIC_CHECK);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
