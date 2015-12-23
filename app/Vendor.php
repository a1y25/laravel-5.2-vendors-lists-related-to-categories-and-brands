<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name','address'];

	public function brands(){
    	return $this->belongsToMany('App\Brand', 'vendors_brands');
    }

    public function categories(){
    	return $this->belongsToMany('App\Category','vendors_categories');
    }
}