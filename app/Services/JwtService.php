<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtService
{
  protected static $secretKey = '';
  protected static $algorithm = 'HS256';

  public function __construct()
  {
    $this->secretKey = getenv('jwt.secret') ?: 'voce_deveria_alterar_isso';
  }

  public static function generateToken(int $userId): string
  {
    $issuedAt = time();
    $expiration = $issuedAt + (2 * 60 * 60);

    $payload = [
      'sub' => $userId,
      'iat' => $issuedAt,
      'exp' => $expiration,
    ];

    return JWT::encode($payload, self::$secretKey, self::$algorithm);
  }

  public static function validateToken(string $token): object|false
  {
    try {
      return JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
    } catch (Exception $e) {
      return false;
    }
  }
}
