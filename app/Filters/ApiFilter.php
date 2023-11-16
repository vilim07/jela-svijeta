<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $allowedParams = [];

    protected $columnMap = [];
    public function transform(Request $request)
    {


        $eloQuery = [];
        foreach ($this->allowedParams as $param) {
            $query = $request->query($param);

            if ($query === null) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;
            
            $eloQuery[] = [$column, '=', $query];
        }

        
        return $eloQuery;

    }
}