<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\VarDumper\Cloner\Data;

class UserData extends Model
{
    use HasFactory;

    protected $table = "user_data";

    protected $guarded = [];

}
