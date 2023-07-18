<?php

namespace App\Imports;

use App\Models\Data;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeImport;


class ExcelImport implements ToCollection, WithChunkReading, ShouldQueue, WithStartRow
{
    // use RegistersEventListeners;


    protected $filename;

    public function  __construct($filename)
    {
        $this->filename = $filename;
    }

    public function Collection(collection $rows)
    {

        foreach ($rows as $row) {
            $mapLocations = explode(',', $row[34]);
            $data = Data::updateOrCreate([
                'NAME' => $row[7],
                'GENDER' => $row[14],
                'USAGE' =>  $row[3],
                'PLOT_NUMBER' =>  $row[5],
            ], [
                'P_NUMBER' =>  $row[1] == '' ? '-' : $row[1],
                'AREA' => $row[2] == '' ? '-' : $row[2],
                'USAGE' =>  $row[3] == '' ? '-' : $row[3],
                'TOTAL_AREA' => $row[4] == '' ? '-' : $row[4],
                'PLOT_NUMBER' =>  $row[5] == '' ? '-' : $row[5],
                'EMIRATE' =>  $row[6] == '' ? '-' : $row[6],
                'NAME' => $row[7] == '' ? '-' : $row[7],
                'AREA_OWNED' => $row[8] == '' ? '-' : $row[8],
                'ADDRESS' => $row[9] == '' ? '-' : $row[9],
                'PHONE' =>  $row[10] == '' ? '-' : $row[10],
                'EMAIL' =>  $row[11] == '' ? '-' : $row[11],
                'FAX' =>  $row[12] == '' ? '-' : $row[12],
                'PO_BOX' =>  $row[13] == '' ? '-' : $row[13],
                'GENDER' => $row[14] == '' ? '-' : $row[14],
                'DOB' =>  $row[15] == '' ? '-' : $row[15],
                'MOBILE' =>  $row[16] == '' ? '-' : $row[16],
                'SECONDARY_MOBILE' => $row[17] == '' ? '-' : $row[17],
                'PASSPORT' => $row[18] == '' ? '-' : $row[18],
                'ISSUE_DATE' =>  $row[19] == '' ? '-' : $row[19],
                'EXPIRY_DATE' => $row[20] == '' ? '-' : $row[20],
                'PLACE_OF_ISSUE' =>  $row[21] == '' ? '-' : $row[21],
                'EMIRATES_ID_NUMBER' =>  $row[22] == '' ? '-' : $row[22],
                'EMIRATES_ID_EXPIRY_DATE' => $row[23] == '' ? '-' : $row[23],
                'RESIDENCE_COUNTRY' =>  $row[24] == '' ? '-' : $row[24],
                'NATIONALITY' =>  $row[25] == '' ? '-' : $row[25],
                'Master_Project' =>  $row[26] == '' ? '-' : $row[26],
                'Project' =>  $row[27] == '' ? '-' : $row[27],
                'Building_Name' =>  $row[28] == '' ? '-' : $row[28],
                'Agents' =>  $row[29] == '' ? '-' : $row[29],
                'Flat_Number' => $row[30] == '' ? '-' : $row[30],
                'No_of_Beds' => $row[31] == '' ? '-' : $row[31],
                'Floor' =>  $row[32] == '' ? '-' : $row[32],
                'registration_number' =>  $row[33] == '' ? '-' : $row[33],
                'lat' =>  $row[34] == '' ? '' : $mapLocations[0],
                'lng' =>  $row[34] == '' ? '' : $mapLocations[1],
                'file' => $this->filename,
            ]);
        }
    }

    public static function beforeImport(BeforeImport $event)
    {
        $options = LIBXML_COMPACT | LIBXML_PARSEHUGE;

        \PhpOffice\PhpSpreadsheet\Settings::setLibXmlLoaderOptions($options);
    }

    public function batchSize(): int
    {
        return 100;
    }


    public function chunkSize(): int
    {
        return 100;
    }
    public function startRow(): int
    {
        return 2;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
