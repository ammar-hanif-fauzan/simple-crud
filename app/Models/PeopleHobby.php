<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleHobby extends Model
{
    use HasFactory;

    protected $table = 'people_hobbies';
    protected $fillable = ['people_id', 'hobby_id'];

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function hobby()
    {
        return $this->belongsTo(Hobby::class);
    }
}
