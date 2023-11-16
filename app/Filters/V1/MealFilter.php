<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class MealFilter extends ApiFilter
{
    protected $allowedParams = [
        'diffTime',
    ];

    protected $columnMap = [
        'diffTime' => 'diff_time',
    ];
}