<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function people()
    {
        return $this->belongsToMany(People::class, 'people_hobbies', 'hobby_id', 'people_id');
    }
}
