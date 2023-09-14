<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Member;
use App\Models\SubAsset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class AllocationsImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, WithEvents, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $asset_use_id;
    public $membership_numbers = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($asset_use_id)
    {
        $this->asset_use_id = $asset_use_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $area = Area::where('name', $row['area'])->where('asset_use_id', $this->asset_use_id)->first();
        $member = Member::where('membership_number', $row['membership_number'])->first();
        if ($area) {

            $subasset = SubAsset::updateOrCreate(
                [ 'survey_no' => $row['survey_no'], 'area_id' => $area->id, 'asset_id' => '1'],
                ['member_id' => $member->id, 'parcel_no' => array_key_exists('parcel_no', $row) ? $row['parcel_no'] == NULL || $row['parcel_no'] == "" ? NULL : $row['parcel_no'] : NULL, 'acres' => $row['hectares'] * 2.4710538146717]
            );

        } else {
            //if area doesn't exist then sub asset doesn't exist
            $area = Area::create([
                'name' => $row['area'], 'asset_use_id' => $this->asset_use_id,
            ]);

            //add the parcel first with survey_no
            $subasset = SubAsset::create([
                'member_id' => $member->id,
                'survey_no' => $row['survey_no'],
                'parcel_no' => array_key_exists('parcel_no', $row) ? $row['parcel_no'] == NULL || $row['parcel_no'] == "" ? NULL : $row['parcel_no'] : NULL,
                'asset_id' => '1',
                'acres' => $row['hectares'] * 2.4710538146717,
                'area_id' => $area->id
            ]);


        }
        return $subasset;


    }

    public function rules(): array
    {
        return [
            'membership_number' => 'required|exists:members',
            'survey_no' => 'required',
            'hectares' => 'required',
            'parcel_no' => 'nullable',
            'area' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [

            AfterImport::class => function (AfterImport $event) {
                Log::info("allocation import", $this->membership_numbers);
            },
        ];
    }

}
