<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportEtape extends Model
{
    use HasFactory;
    protected $fillable=['nom','longueur','nbr_coureur','rang','date_depart','heure_depart'];
}
 