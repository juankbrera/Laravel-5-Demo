<?php

namespace App\Models;

use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use RevisionableTrait, SearchableTrait;

    /**
     * Enable revisions from Revisionable
     *
     * @var
     */
    protected $revisionEnabled = true;

    /**
     * Enable creation revisions
     * @var
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Remove old revisions
     *
     * @var
     */
    protected $revisionCleanup = true;

    /**
     * Maintain a maximum of 100 changes at any point of time, while cleaning up old revisions.
     *
     * @var
     */
    protected $historyLimit = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'slug',
        'name',
        'photo',
        'description',
        'price',
        'likes',
        'stock',
        'is_active'
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
