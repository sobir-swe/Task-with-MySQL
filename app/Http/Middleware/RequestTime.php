<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startRequestTime = microtime(true);

        DB::enableQueryLog();

        $response = $next($request);
        $endRequestTime = microtime(true);
        $executionTime = round(($endRequestTime - $startRequestTime) * 1000, 2);

        Log::info('Request executed in ' . $executionTime . ' ms');
        $queries = DB::getQueryLog();
        $totalQueryTime = 0;

        foreach ($queries as $query) {
            $totalQueryTime += $query['time'];
        }

        Log::info('Total SQL query time for this request: ' . $totalQueryTime . ' ms');

        return $response;
    }
}
