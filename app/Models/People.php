<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'name',
    ];

    public function idCard()
    {
        return $this->hasOne(IdCard::class);
    }

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'people_hobbies', 'people_id', 'hobby_id');
    }
}
