<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignmenu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','assign_by','assign_to','menu_id',
    ];
    protected $table = "assign_menu";
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
    ];
}
