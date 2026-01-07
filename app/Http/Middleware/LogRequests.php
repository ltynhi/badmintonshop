<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle(Request $request, Closure $next)
    {
        // Log request details
        Log::info('Request received', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'headers' => $request->headers->all(),
            'input' => $request->all(),
            'user_id' => auth()->id(),
            'is_authenticated' => auth()->check()
        ]);

        $response = $next($request);

        // Log response
        Log::info('Response sent', [
            'status' => $response->getStatusCode(),
            'path' => $request->path()
        ]);

        return $response;
    }
}