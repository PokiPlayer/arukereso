<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyJSONAccept
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!$request->isMethod(Request::METHOD_POST)) return $next($request);

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader !== 'application/json') {
            return response()->json([], Response::HTTP_NOT_ACCEPTABLE);
        }

        return $next($request);
    }
}
