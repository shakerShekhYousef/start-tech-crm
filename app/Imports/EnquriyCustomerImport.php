<?php

namespace App\Imports;

use App\Models\booktable;
use Exception;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\BeforeImport;

class EnquriyCustomerImport implements ToCollection, WithHeadingRow
{
    public function Collection(collection $rows)
    {
        foreach ($rows as $key => $row) {
            try {
                if ($row['name'] != null)
                    booktable::updateOrCreate([
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                    ], [
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                        'campaign_name' => isset($row['campaign_name'])? $row['campaign_name'] : null,
                        'utm_source' => isset($row['utm_source']) ? $row['utm_source'] : null,
                        'utm_medium' => isset($row['utm_medium'])? $row['utm_medium']: null,
                        'utm_campaign' => isset($row['utm_campaign'])? $row['utm_campaign'] : null,
                        'title' => isset($row['title']) ? $row['title'] : null,
                        'number_of_beds' => isset($row['number_of_beds'])? $row['number_of_beds']:null,
                        'comment' => isset($row['comment'])? $row['comment']:null,
                        'project' => isset($row['project'])? $row['project'] : null,
                        'is_enquiry_customer' => true,
                        'created_by' => Auth::user()->id
                    ]);
            } catch (Exception $ex) {
                dd($ex);
            }
        }
    }

    public static function beforeImport(BeforeImport $event)
    {
        $options = LIBXML_COMPACT | LIBXML_PARSEHUGE;

        \PhpOffice\PhpSpreadsheet\Settings::setLibXmlLoaderOptions($options);
    }
}
