<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditorFile extends Model
{
    protected $fillable = [
        'user_id', 'file_id', 'sended_to_researcher',
    ];
    protected $table = "editor_file";

}
