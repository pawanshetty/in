<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;


class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role()
	{
		return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'group_user','user_id','group_id');
    }
    
	public function isAdmin()
    {
        if($this->role_id == 1){
            return true;
        }
        return false;
    }

    public function containsGroup($group)
    {
       return $this->groups->contains($group->id);
    }

    /**
     * to ensure the size of the images are with 50*50
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function getProfileImage(){
        if($this->getMedia('avatars')->first() != null){
            return $this->getMedia('avatars')->first()->getUrl('thumb');
        }else{
            return "https://via.placeholder.com/150";
        }
    }


    
}
