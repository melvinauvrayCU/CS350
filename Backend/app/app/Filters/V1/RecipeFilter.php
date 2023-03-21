<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

/**
 * Class used to perform a filter on the recipes according to parameters passed in URL.
 * We put this class in a V1 folder as we can use version for the next updates
 */
class RecipeFilter extends ApiFilter
{
    // List of the parameters from the Recipe model we can search for, with what we can filter 
    protected $safeParams = [
        'title' => ['eq'],
        'numberPeople' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'rating' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'userId' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'id' => ['eq', 'gt', 'gte', 'lt', 'lte'],
    ];

    // Used to convert camelCase column names to camel_case string format
    // camelCase is used in request and camel_case is used in SQL tables
    protected $columnMap = [
        'userId' => 'user_id',
        'numberPeople' => 'number_people',
    ];

    /**
     * Map array to convert keywords to mathematical operators.
     */
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];
}
