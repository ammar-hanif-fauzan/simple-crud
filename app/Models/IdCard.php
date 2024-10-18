<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    use HasFactory;

    protected $table = 'id_cards';

    protected $fillable = [
        'people_id',
        'id_number',
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
