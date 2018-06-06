<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    protected $with = ['creator'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
