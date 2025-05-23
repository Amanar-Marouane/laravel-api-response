<?php

namespace Unk\LaravelApiResponse\Traits;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;

trait HttpResponseWithDataTables
{
    use HttpResponse;

    protected function successDataTable($data, $draw = 1, $start = 0, $length = 10, $message = null, $code = 200): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->resolve(Request::instance());
        }

        $datatable = DataTables::of($data)->make(true);
        $response = $datatable->getData(true);

        $currentPage = floor($start / $length) + 1;
        $totalPages = ceil($response['recordsFiltered'] / $length);

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $response['data'],
            'recordsTotal' => $response['recordsTotal'],
            'recordsFiltered' => $response['recordsFiltered'],
            'draw' => $draw,
            'pagination' => [
                'total' => $response['recordsTotal'],
                'per_page' => $length,
                'current_page' => $currentPage,
                'last_page' => $totalPages,
                'from' => $start + 1,
                'to' => min($start + $length, $response['recordsFiltered']),
                'has_more_pages' => $currentPage < $totalPages
            ]
        ], $code);
    }

    protected function errorDataTable($draw = 1, $length = 10, $message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
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
                'has_more_pages' => false
            ]
        ], $code);
    }
}
