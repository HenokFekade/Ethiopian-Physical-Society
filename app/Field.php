<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [ 
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
