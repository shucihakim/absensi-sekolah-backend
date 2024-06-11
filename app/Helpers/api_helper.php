<?php

use Illuminate\Support\Facades\Log;

function api_success(string $message, $result = null, ?int $status = 200)
{
    $response = [
        'success' => true,
        'message' => $message
    ];
    if (isset($result)) $response['result'] = $result;
    return response()->json($response, $status);
}

function api_failed(string $message, $error = null, ?int $status = 400)
{
    $response = [
        'success' => false,
        'message' => $message,
    ];
    if (isset($error)) $response['error'] = $error;
    return response()->json($response, $status);
}

function api_error(Exception $e, ?int $status = 500)
{
    Log::error($e);
    $response = [
        'success' => false,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ];
    return response()->json($response, $status);
}

function upload_file($file, $folder)
{
    try {
        if ($file) {
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/' . $folder), $file_name);
            return $file_name;
        }
        return null;
    } catch (Exception $e) {
        return api_error($e);
    }
}
