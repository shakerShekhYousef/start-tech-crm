<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowUpLeads extends Model
{
    use HasFactory;
    protected $table = "user_follow_up_leads";

    protected $guarded = [];
}
