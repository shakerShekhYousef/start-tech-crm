<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InventoryImport implements ToModel, WithStartRow
{

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new Inventory([
            'serial_num' => $row[0],
            'date_listed' => $row[1],
            'agent_name' => $row[2],
            'category' => $row[3],
            'building_status' => $row[4],
            'client_name' => $row[5],
            'unit_for_sales' => $row[6],
            'unit_number' => $row[7],
            'community_location' => $row[8],
            'property_type' => $row[9],
            'bedrooms' => $row[10],
            'specifications' => $row[11],
            'property_size' => $row[12],
            'unite_price' => $row[13],
            'remarks' => $row[14],
            'source_of_lead' => $row[15],
            'developer' => $row[16],
            'building_name' => $row[17],
            'property_name' => $row[18],
            'plot_area' => $row[19],
            'customer_name' => $row[20],
            'email_address' => $row[21],
            'mobile' => $row[22],
            'comments' => $row[23],
            'nationality' => $row[24],
            'furniture' => $row[25],
            'customer_type' => $row[26],
            'can_add' => $row[27],
            'roi' => $row[28],
            'telephone_number' => $row[29],
            'telephone_residence' => $row[30],
            'telephone_office' => $row[31],
            'general' => $row[32],
            'property_finder_link' => $row[33],
            'buyut_link' => $row[34],
            'dubizzle_link' => $row[35],
            'wow_propties_link' => $row[36],
            'other_links' => $row[37],
            'floors' => $row[38],
            'service_charge' => $row[39],
            'payment_plan' => $row[40],
            'rent' => $row[41],
            'ready_off' => $row[42],
            'handover' => $row[43],
            'price_aed' => $row[44],
            'bathrooms' => $row[45],
            'completion' => $row[46],
            'status' => $row[47]
        ]);
    }
}
