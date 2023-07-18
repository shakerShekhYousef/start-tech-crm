<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WonLeads extends Model
{
    use HasFactory;
    protected $table = "won_leads";
    protected $guarded = [];
}
