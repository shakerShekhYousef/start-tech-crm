<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booktable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userleadspooldatacomments()
    {
        return $this->hasMany('App\Models\UserLeadsPoolComment', 'leads_pool_id', 'id');
    }

}
