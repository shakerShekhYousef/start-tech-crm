<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQualifiedLeadsComment extends Model
{
    use HasFactory;
    protected $table = "user_qualified_leads_comments";
    protected $guarded = [];
}
