<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $table = 'phone_numbers';

    protected $fillable = [
        'people_id',
        'phone_number',
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
