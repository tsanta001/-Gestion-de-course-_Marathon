<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportResultat extends Model
{
    use HasFactory;
    protected $fillable=['etape_rang','num_dossard','coureur_nom','genre','ddn','equipe_nom','arrivee'];

}

