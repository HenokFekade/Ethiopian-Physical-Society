<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['id', 'original_name', 'path', 'researcher_email', 'field_id', ];     

    public function users()
    {
        return  $this->belongsToMany(User::class)->withPivor('replied')->withPivot('rejected')->withPivot('seen')->withTimestamps();
    }

    public function fields()
    {
        return $this->belongsTo(Field::class);
    }
}
