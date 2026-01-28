<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    //attributes that are mass assignable should be placed in fillable,  mass assigned= createing a record in db table
    //UNDERSTANDING FILLABLE- w/o fillable mass assignment becomes hard
    protected $fillable = [
        'name',
        'slug',
        'type',
        'icon',
        'color',
        'description',
        'is_active'
    ];

    //ATTRIBUTES THAT SHOULD BE CAST i.e AUTOMATICE TYPE CONVERSION
    protected $casts = [
        'is_active' => 'boolean', //1 becomes true and 0 becomes false
        'created_at' => 'datetime', //string becomes carbon date object
        'updated_at' => 'datetime',
    ];
    //attribuetes that must be hidden
    protected $hidden = [];
    
    public function transactions(){
        return $this->hasMany(Transaction::class, 'category_id', 'category_id');
    }
}
