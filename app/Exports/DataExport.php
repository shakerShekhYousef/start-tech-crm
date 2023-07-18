<?php

namespace App\Exports;

use App\Models\Data;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;

class DataExport implements FromCollection,WithHeadings,WithColumnFormatting,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
     private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection(){
        
        $filter=$this->data;
       
        return $filter;
      
    }

    // public function collection()
    // {
    //     $reg =  Data::select('id','P_NUMBER','AREA','USAGE','TOTAL_AREA','PLOT_NUMBER',
    //     'EMIRATE','NAME','AREA_OWNED','ADDRESS','PHONE','EMAIL','FAX','PO_BOX',
    //     'GENDER','DOB','MOBILE','SECONDARY_MOBILE','PASSPORT','ISSUE_DATE','EXPIRY_DATE','PLACE_OF_ISSUE',
    //     'EMIRATES_ID_NUMBER','EMIRATES_ID_EXPIRY_DATE','RESIDENCE_COUNTRY','NATIONALITY','Master_Project','Project','Building_Name','Agents',
    //     'Flat_Number','No_of_Beds','Floor','registration_number')->get();
      
    //     return $reg;
    // }

    public function headings(): array
    {
        return [
            '#',
            'P-NUMBER',
            'AREA',
            'USAGE',
            'TOTAL AREA',
            'PLOT NUMBER',
            'EMIRATE',
            'NAME',
            'AREA OWNED',
            'ADDRESS',
            'PHONE',
            'EMAIL',
            'FAX',
            'PO BOX',
            'GENDER',
            'DOB',
            'MOBILE',
            'SECONDARY MOBILE',
            'PASSPORT',
            'ISSUE DATE',
            'EXPIRY DATE',
            'PLACE OF ISSUE',
            'EMIRATES ID NUMBER',
            'EMIRATES ID EXPIRY DATE',
            'RESIDENCE COUNTRY',
            'NATIONALITY',
            'Master Project',
            'Project',
            'Building Name',
            'Agents',
            'Flat Number',
            'No Of Beds',
            'Floor',
            'Registration Number',
            'lat',
            'lng',
            'UNIQUE'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->setRightToLeft(true)->getFont()->setSize(14)->setWrapText(true);
            },
        ];
    }
}
