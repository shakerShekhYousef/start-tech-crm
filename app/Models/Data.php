<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'created_at', 'file', 'updated_at'
    ];

    const columns = [
        'P_NUMBER', 'AREA', 'USAGE', 'TOTAL_AREA', 'PLOT_NUMBER',
        'EMIRATE', 'NAME', 'AREA_OWNED', 'ADDRESS', 'PHONE', 'EMAIL', 'FAX', 'PO_BOX',
        'GENDER', 'DOB', 'MOBILE', 'SECONDARY_MOBILE', 'PASSPORT', 'ISSUE_DATE', 'EXPIRY_DATE', 'PLACE_OF_ISSUE',
        'EMIRATES_ID_NUMBER', 'EMIRATES_ID_EXPIRY_DATE', 'RESIDENCE_COUNTRY', 'NATIONALITY', 'Master_Project', 'Project', 'Building_Name', 'Agents',
        'Flat_Number', 'No_of_Beds', 'Floor', 'registration_number', 'lat', 'lng', 'file'
    ];

    public function userdatacomments()
    {
        return $this->hasMany(userdatacomments::class);
    }
}
