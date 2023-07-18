<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeadsPoolComment extends Model
{
    use HasFactory;
    protected $table = "user_leads_pool_comments";

    protected $guarded = [];
}
