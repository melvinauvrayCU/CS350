<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class RecipeFilter extends ApiFilter
{
    // TODO: 
    protected $safeParams = [
        'title' => ['eq'],
        'numberPeople' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'rating' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'userId' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'id' => ['eq', 'gt', 'gte', 'lt', 'lte'],
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'numberPeople' => 'number_people',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];
}
