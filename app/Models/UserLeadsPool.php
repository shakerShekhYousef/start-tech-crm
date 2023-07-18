<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeadsPool extends Model
{
    use HasFactory;
    protected $table = "user_leads_pools";

    protected $guarded = [];
}
