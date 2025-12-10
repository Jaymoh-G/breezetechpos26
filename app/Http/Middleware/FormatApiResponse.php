<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FormatApiResponse
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        /** @var SymfonyResponse|JsonResponse $response */
        $response = $next($request);

        if (! $request->is('api/*')) {
            return $response;
        }

        if ($response instanceof JsonResponse) {
            $payload = $response->getData(true);

            if (isset($payload['success'])) {
                return $response;
            }

            $status = $response->getStatusCode();

            return $response->setData([
                'success' => $status >= 200 && $status < 300,
                'message' => $payload['message'] ?? ($payload['error'] ?? SymfonyResponse::$statusTexts[$status] ?? ''),
                'data' => $status >= 200 && $status < 300 ? $payload : null,
                'errors' => $status >= 400 ? $payload : null,
            ]);
        }

        $status = $response->getStatusCode();
        $content = $response->getContent();

        return new JsonResponse([
            'success' => $status >= 200 && $status < 300,
            'message' => SymfonyResponse::$statusTexts[$status] ?? '',
            'data' => $status >= 200 && $status < 300 ? $content : null,
            'errors' => $status >= 400 ? $content : null,
        ], $status, $response->headers->all());
    }
}

