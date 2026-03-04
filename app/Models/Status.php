<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'name',
        'context',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
