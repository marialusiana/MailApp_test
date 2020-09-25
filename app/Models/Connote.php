<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'connote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id'];
    
}
