<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';
    protected $fillable = [
        'hotel_name',
        'hotel_image',
        'destination_id',
    ];
    //
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

   
}
