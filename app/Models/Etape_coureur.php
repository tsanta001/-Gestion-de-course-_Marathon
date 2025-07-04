<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape_coureur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_etape','id_coureur','date_depart','heure_depart','arriver','point'
    ];
}
