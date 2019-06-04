<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Products extends Model
{
    protected $fillable = [
        'name', 'user_id', 'description'
    ];

    public static $rules = [
        'name'=>'required|min:6',
        'user_id'=>'required',        
        'description'=>'required'       
    ];
       
    public static function validateProduct($data)
    {
        $validator = Validator::make($data, self::$rules);
        if ($validator->fails()) {
          return $validator->errors()->toArray();
        }
        return true;

    }
}