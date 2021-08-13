<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
    	'post_name_th',
    	'post_name_en',
    	'post_description',
    	'image',
    	'category_id',
    ];
}
