<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur extends Model
{
    use HasFactory;
    protected $fillable=['id','nom','num_dossard','genre','ddn','id_equipe'];
}
