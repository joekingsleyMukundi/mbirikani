<?php

namespace App\Imports;

use App\Models\SubAsset;
use App\Models\Area;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubAssetsImport implements ToModel, WithHeadingRow
{
    public $asset_id;
    public $asset_use_id;
    public $area_id;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($asset_id, $asset_use_id, $area_id)
    {
        $this->asset_id = $asset_id;
        $this->asset_use_id = $asset_use_id;
        $this->area_id = $area_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $area = Area::where('id', $this->area_id)->where('asset_use_id', $this->asset_use_id)->first();
        
        if ($area) {

            //check if sub asset exists under area with same survey no
            $subasset = SubAsset::where(['survey_no' => $row['survey_number'], 'area_id' => $area->id])->first();


            if (!$subasset) {
                //add the parcel with survey_no
                $subasset = SubAsset::create([
                    'survey_no' => $row['survey_number'],
                    'asset_id' => '1',
                    'acres' => $row['hectares'] * 2.4710538146717,
                    'area_id' => $area->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }



        } else {
            //if area doesn't exist then sub asset doesn't exist
            $area = Area::create([
                'name' => $row['area'], 'asset_use_id' => $this->asset_use_id,
            ]);

            //add the parcel first with survey_no
            $subasset = SubAsset::create([
                'survey_no' => $row['survey_number'],
                'asset_id' => '1',
                'acres' => $row['hectares'] * 2.4710538146717,
                'area_id' => $area->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);


        }
        
        return $subasset;

        
    }
}
