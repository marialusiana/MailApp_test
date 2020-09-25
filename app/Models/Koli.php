<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koli extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'koli';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];
    
}
