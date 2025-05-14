<?php

namespace App\Services;

class ApiResponse
{
  protected static $statusCodes = [
    200 => 'OK',
    201 => 'Created',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
  ];

  public static function send($data = null, $status = 200, $message = null)
  {
    $response = service('response');

    $message = $message ?? self::$statusCodes[$status] ?? 'Unknown Status';

    $payload = [
      'status' => $status,
      'error' => $status >= 400,
      'message' => $message,
      'data' => $data,
    ];

    return $response->setStatusCode($status)->setJSON($payload);
  }
}
