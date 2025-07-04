<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportPoint extends Model
{
    use HasFactory;
    protected $fillable=['classement','point'];
}
