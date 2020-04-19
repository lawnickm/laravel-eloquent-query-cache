<?php

namespace Rennokki\QueryCache\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Book extends Model
{
    use QueryCacheable;

    protected $cacheUsePlainKey = true;

    protected $fillable = [
        'name',
    ];
}
