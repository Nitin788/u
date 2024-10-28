<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    protected $table = "homepages";
    protected $fillable = [
        'slider_images',
        'title',
        'card_images_title',
        'book_offer',
        'card_description',
        'status',
    ];
}
