<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body'];

    private static $rules = [
        'title' => 'min:3|max:32|unique:notes',
        'body' => 'min:3|max:1000'
    ];

    public static function getRules()
    {
        return self::$rules;
    }
}
