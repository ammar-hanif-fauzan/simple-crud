<?php

namespace App\Models;

use App\Models\People;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(People::class, 'people_id');
    }
}
