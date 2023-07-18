<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadLeads extends Model
{
    use HasFactory;
    protected $table = "dead_leads";
    protected $guarded = [];
}
