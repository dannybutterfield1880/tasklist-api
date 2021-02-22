<?php


namespace Core\Utils;


use DateTime;
use Firebase\JWT\JWT;

class JWTEncoder
{

    static public function encode($user): string
    {
        $date = new DateTime();
        $timeStamp = $date->getTimestamp();
        $anHour = 1 * (60 * 60);

        $payload = array(
            "uid" => $user->getId(),
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "iss" => "http://localhost", //issuer
            "aud" => "http://localhost", //audience
            "iat" => $timeStamp, //issued at
            "exp" => $timeStamp + $anHour //expiry date
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
         return JWT::encode($payload, 'task-lists');

    }

    static public function decode($token, $key)
    {
        return JWT::decode($token, $key, array('HS256'));

        return $decoded;
        dump($decoded);

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

        $decoded_array = (array) $decoded;

        /**
         * You can add a leeway to account for when there is a clock skew times between
         * the signing and verifying servers. It is recommended that this leeway should
         * not be bigger than a few minutes.
         *
         * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
         */
        JWT::$leeway = 60; // $leeway in seconds
        return JWT::decode($token, $key, array('HS256'));
    }

}
