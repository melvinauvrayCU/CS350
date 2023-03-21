<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * Class we will extends from the modelFilter classes.
 * Perform the transformation of the query based on the request and the search keyword allowed.
 * Search keywords allowed are specified in variables safeParams, columnMap, operatorMap that are implemented in the child classes.
 */
class ApiFilter
{
    protected $safeParams = [];
    protected $columnMap = [];
    protected $operatorMap = [];

    /**
     * Tbh i'm not completely sure I understand this function so I'll not comment it
     */
    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
