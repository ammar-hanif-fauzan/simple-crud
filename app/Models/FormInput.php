<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormInput extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'email',
        'password',
        'checkbox',
        'radio',
        'select',
        'file',
        'textarea',
        'date',
        'number',
        'range',
        'color'
    ];
}
