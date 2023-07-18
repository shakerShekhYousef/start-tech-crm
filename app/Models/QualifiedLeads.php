<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualifiedLeads extends Model
{
    use HasFactory;
    protected $table = "qualified_leads";
    protected $guarded = [];

    public function userqualifiedleadscomments()
    {
        return $this->hasMany('App\Models\UserQualifiedLeadsComment');
    }
}
