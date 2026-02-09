<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'transaction_id';
    //attributes that are mass assignable should be placed in fillable,  mass assigned= createing a record in db table
    //UNDERSTANDING FILLABLE- w/o fillable mass assignment becomes hard
    protected $fillable = [
        'user_id',
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    //Quesry scopes
    //scope to filter data by expense
    public function scopeIncome(Builder $query):Builder
    {
        return $query->where('type','expense');
    }

    //scope to filter by date range
    public function scopeDateRange(Builder $query, $startDate, $endDate):Builder
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    //scope to filter by category
    public function scopeCategory(Builder $query, $category_id):Builder
    {
        return $query->where('category_id', $category_id);
    }

    //accessors and mutators
    //custom currency format 
    protected function formattedAmount():CastsAttribute
    {
        return CastsAttribute::make(
            get: fn () => 'Rs. '.number_format($this->amount,2)
        );
    }

    //automatically uppercase description
    protected function formattedDescription(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }
}