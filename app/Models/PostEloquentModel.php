<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $primaryKey = 'id';

    public function slika()
    {
        return $this->hasOne(SlikaEloquent::class,'id');
    }
}
