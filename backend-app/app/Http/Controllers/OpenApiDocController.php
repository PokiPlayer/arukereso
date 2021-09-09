<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class OpenApiDocController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $appVersion = env("APP_VERSION");
        $fileName   = sprintf('api_V%s_swaggerV2.0.json', $appVersion);
        $content    = Storage::disk('local')->get('docs/'.$fileName);

        return response($content);
    }
}
