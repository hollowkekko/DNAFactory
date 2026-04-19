<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    use HasFactory;

    protected $primaryKey = 'mal_id';
    public $incrementing = false;
    protected $fillable = ['mal_id', 'title', 'image_url', 'synopsis', 'score'];
}