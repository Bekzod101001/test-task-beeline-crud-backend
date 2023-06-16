<?php


namespace App\Traits;


use App\Http\Resources\PaginationResource;
use Illuminate\Http\JsonResponse;

trait ApiTrait
{
    protected function success($data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json($data ?? $message, $code);
    }
    protected function successPagination($resource, $items): JsonResponse
    {
        return $this->success([
            'items' => $resource::collection($items),
            'pagination' => new PaginationResource($items)
        ]);
    }

    protected function permissionDeniedError(): JsonResponse
    {
        return $this->error('Permission Denied. User do not has permission for this action', 'PermissionDenied');
    }

    protected function error(
        string $errorMessage = null,
               $errorCode = null,
        int $httpStatusCode = 403,
               $additionalData = []
    ): JsonResponse {
        $response = [];

        if ($additionalData) {
            $response = $additionalData;
        }

        if ($errorMessage) {
            $response['errorMessage'] = $errorMessage;
        }
        if ($errorCode) {
            $response['errorCode'] = $errorCode;
        }

        return response()->json($response, $httpStatusCode);
    }

    protected function notAuthenticatedError(): JsonResponse
    {
        return $this->error('Not Authenticated', 'NotAuthenticated', 401);
    }

    protected function notFoundError(): JsonResponse
    {
        return $this->error('Not Found', null, 404);
    }
}
