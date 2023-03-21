<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

/**
 * Class used to perform a filter on users according to parameters passed in URL.
 * We put this class in a V1 folder as we can use version for the next updates
 */
class UserFilter extends ApiFilter
{
    // List of the parameters from the User model we can search for, with what we can filter 
    protected $safeParams = [
        'name' => ['eq'],
        'email' => ['eq'],
        'id' => ['eq', 'gt', 'gte', 'lt', 'lte'],
    ];

    /**
     * We don't have any camelCase conversion to do so we keep this array empty
     */
    protected $columnMap = [];

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
