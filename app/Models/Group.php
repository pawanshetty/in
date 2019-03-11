<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Group extends Model
{
    protected $table = 'groups';
    
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'group_user', 'group_id','user_id');
    }

    public function containsUser($user)
    {    
        return $this->users->contains($user->id);
    }
}
