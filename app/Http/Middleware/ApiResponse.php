<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Type', 'application/json');

        if (in_array($response->status(), [200, 201])) {
            $response->setContent(
                json_encode(
                    [
                        'success' => true,
                        'data' => json_decode($response->content())
                    ]
                )
            );
        }
        if (in_array($response->status(), [400, 401, 404, 422])) {
            $response->setContent(
                json_encode(
                    [
                        'success' => false,
                        'error' => json_decode($response->content())->errors,
                    ]
                )
            );
        }
        if ($response->status() == 500) {
            $response->setContent(
                json_encode(
                    [
                        'success' => false,
                        'error' => $response->exception->getMessage(),
                    ]
                )
            );
        }

        return $response;
    }
}
