<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','parent_id','menu',
    ];
    protected $table = "menu";
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
    ];
}
