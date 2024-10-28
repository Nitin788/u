<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    //
    protected $table = 'destinations';
    protected $fillable = [
        'destination_name',
        'destination_image',
        'country_id',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
