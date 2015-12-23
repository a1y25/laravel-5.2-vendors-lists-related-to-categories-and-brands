<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['title'];
    
    public function vendors(){

    	return $this->belongsToMany('App\Vendor','vendors_categories');
    }
}
