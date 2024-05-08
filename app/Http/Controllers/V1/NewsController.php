<?php

namespace App\Http\Controllers\V1;

use App\Models\News;
use Illuminate\Http\Request;
use App\Filter\V1\FilterNews;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $filter = new FilterNews();
        $filterItems = $filter->transform($request);
        if (isset($filterItems[0][0]) && $filterItems[0][0] == "published_date") {
            $news = News::whereDate($filterItems[0][0], $filterItems[0][1], $filterItems[0][2]);
        } else {
            $news = News::where($filterItems);
        }

        return $news->paginate()->appends($request->query());
    }
}
