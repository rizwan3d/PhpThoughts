<?php

namespace App\Auth\Domain\Entities;
use Illuminate\Database\Eloquent\Model;

class User extends Model{

   protected $table = 'users';
   protected $fillable = ['user_name','email','password','phone_no', 'address','created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
   protected $hidden = ['updated_at','deleted_at','created_by','updated_by', 'deleted_by', 'password'];

}