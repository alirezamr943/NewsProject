<?php

namespace App\Filter;

use Illuminate\Http\Request;


class ApiFilter
{
    protected $safeParms = [];

    protected $culomnMap = [];

    protected $oparatorMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];
        foreach ($this->safeParms as $parm => $oparators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $culomn = $this->culomnMap[$parm] ?? $parm;

            foreach ($oparators as $oparator) {
                if (isset($query[$oparator])) {
                    $eloQuery[] = [$culomn, $this->oparatorMap[$oparator], $query[$oparator]];
                }
            }
        }

        return $eloQuery;
    }
}
