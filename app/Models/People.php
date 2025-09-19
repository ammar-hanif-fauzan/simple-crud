<?php

namespace App\Models;

use App\Models\PhoneNumber;
use App\Models\Hobby;
use App\Models\IdCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class, 'people_id');
    }
}
