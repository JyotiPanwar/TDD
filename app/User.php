<?php

namespace App;

use Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public static $rules = [
        'name'=>'required|unique:users',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6|max:8'
    ];
    
    public static function validateUser($data)
    {
        $validator = Validator::make($data, self::$rules);
        if ($validator->fails()) {
          return $validator->errors()->toArray();
        }
        return true;

    }
}