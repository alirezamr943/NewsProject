<?php

namespace App\Filter\V1;

use App\Filter\ApiFilter;


class FilterNews extends ApiFilter
{

    protected $safeParms = [
        "source" => ["eq"],
        "type" => ["eq"],
        "publishedDate" => [
            "eq",
            "gt",
            "lt",
            "gte",
            "lte",
        ],
    ];

    protected $culomnMap = [
        "publishedDate" => "published_date"
    ];

    protected $oparatorMap = [
        'eq' => '=',
        'ls' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
    ];
}
