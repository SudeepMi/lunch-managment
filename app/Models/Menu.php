<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Menu extends Model
{
    protected $fillable = [
        'menu','unit','created_by'
    ];

    protected $table ='menus';

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->created_by = Auth::guard('cook')->user()->name;

        });
    }
}
