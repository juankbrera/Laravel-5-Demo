<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 'slug', 'name', 'photo', 'description', 'price', 'stock', 'is_active',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
        ]
    ];
}
