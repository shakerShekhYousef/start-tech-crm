<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uploadedFile extends Model
{
    use HasFactory;
    
        protected $fillable = ['fileName','duplicate','numberofimportedrows','created_at'];
}
