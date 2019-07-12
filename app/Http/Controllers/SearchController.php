<?php
namespace App\Http\Controllers;

use App\Services\ServiceCaller;
use App\Services\Search\Tasks\SearchVideos;
use App\Tools\Fomatter\End;
use Illuminate\Http\Request;

class SearchController
{
    public function searchVideos(Request $request)
    {
        $result = ServiceCaller::call(ServiceCaller::TASK_SERVICE,
            new SearchVideos((int)$request->input('app_id'), $request->input('keyword'), (int)$request->input('offset'), (int)$request->input('limit'))
        );

        return End::toSuccessJson($result);
    }
}