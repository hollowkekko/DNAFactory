<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    // 1. Diciamo a Laravel che la chiave primaria si chiama 'mal_id'
    protected $primaryKey = 'mal_id';
    
    // 2. Gli diciamo che non è un numero che si autoincrementa da solo
    public $incrementing = false;

    // 3. Autorizziamo lo script a riempire questi campi
    protected $fillable = ['mal_id', 'title', 'image_url', 'synopsis', 'score', 'episodes'];
}