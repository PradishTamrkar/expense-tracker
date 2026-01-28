<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';
    //attributes that are mass assignable should be placed in fillable,  mass assigned= createing a record in db table
    //UNDERSTANDING FILLABLE- w/o fillable mass assignment becomes hard
    protected $fillable = [
        'category_id',
        'amount',
        'type',
        'description',
        'transaction_date'
    ];

    //ATTRIBUTES THAT SHOULD BE CAST i.e AUTOMATICE TYPE CONVERSION
    protected $casts = [
        'amount'=>'decimal:2',
        'transaction_date'=>'date', //string becomes carbon date object
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
    ];
    //attribuetes that must be hidden
    protected $hidden = []; 

    //get the category that owns the transaction
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
