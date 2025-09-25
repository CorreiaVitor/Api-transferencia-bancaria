<?php

namespace App\Http;

class JWT
{
    public static function token(array $data): string
    {
        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT"
        ]);

        $payload = json_encode($data);

        $base64EncodeHeader = self::base64UrlEncode($header);
        $base64EncodePayload = self::base64UrlEncode($payload);

        $signature = self::signature($base64EncodeHeader . "." . $base64EncodePayload);

        $token = $base64EncodeHeader . "." . $base64EncodePayload . "." . $signature;

        return $token;
    }

    public static function verifyToken(string $data)
    {
        $tokenPartials = explode(".", $data);

        if (count($tokenPartials) !== 3)
            return false;

        [$header, $payload, $signature] = $tokenPartials;

        if ($signature !== self::signature($header . "." . $payload)) 
            return false;

        return self::base64UrlDecode($payload);
    }

    public static function signature(string $data)
    {
        $signature = hash_hmac("sha256", $data, $_ENV['SECRET_KEY'], true);

        return self::base64UrlEncode($signature);
    }

    public static function base64UrlEncode(string $data)
    {
        return strtr(rtrim(base64_encode($data), "="), "+/", "-_");
    }

    public static function base64UrlDecode(string $data)
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat("=", 4 - $padding);

        $data = strtr($data, "-_", "+/");

        return json_decode(base64_decode($data), true);
    }
}
