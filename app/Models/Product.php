<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $with = ['user'];

    public $fillable = [
        'name',
        'description',
        'price',
        'small_description',
        'user_id'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }


}
