<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlikaEloquent extends Model
{
    use HasFactory;

    protected $table = 'slika';
    protected $primaryKey = 'id';
}
