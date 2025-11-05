<?php

namespace Unk\LaravelApiResponse\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponseWithDataTables
{
    use HttpResponse;

    /**
     * Return a standardized success response for DataTables (server-side mode).
     */
    protected function successDataTable(
        $data,
        int $draw = 1,
        int $start = 0,
        int $length = 10,
        ?string $message = null,
        int $code = 200,
        int $recordsTotal = 0,
        int $recordsFiltered = 0
    ): JsonResponse {
        // Resolve resource collections if necessary
        if ($data instanceof JsonResource) {
            $data = $data->resolve();
        }

        // Prevent divide by zero
        $length = max(1, $length);

        $currentPage = (int) floor($start / $length) + 1;
        $totalPages = (int) ceil($recordsFiltered / $length);

        $response = new JsonResponse();
        return $response->setJson(json_encode([
            'status' => 'success',
            'message' => $message ?? 'Data loaded successfully.',
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'draw' => $draw,
            'pagination' => [
                'total' => $recordsFiltered,
                'per_page' => $length,
                'current_page' => $currentPage,
                'last_page' => $totalPages,
                'from' => $recordsFiltered > 0 ? $start + 1 : 0,
                'to' => min($start + $length, $recordsFiltered),
                'has_more_pages' => $currentPage < $totalPages,
            ],
        ]))
            ->setStatusCode($code);
    }

    /**
     * Return a standardized error response for DataTables.
     */
    protected function errorDataTable(
        int $draw = 1,
        int $length = 10,
        ?string $message = null,
        int $code = 400
    ): JsonResponse {
        $length = max(1, $length);

        $response = new JsonResponse();
        return $response->setJson(json_encode([
            'status' => 'error',
            'message' => $message ?? 'An error occurred while loading data.',
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'draw' => $draw,
            'pagination' => [
                'total' => 0,
                'per_page' => $length,
                'current_page' => 1,
                'last_page' => 1,
                'from' => 0,
                'to' => 0,
                'has_more_pages' => false,
            ],
        ]))
            ->setStatusCode($code);
    }
}
