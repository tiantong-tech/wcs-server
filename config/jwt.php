<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'key' => env('JWT_KEY'),

    'alg' => env('JWT_ALG'),

    // Time to live
    'ttl' => env('JWT_TTL'),

    // Refresh time to live
    'rft' => env('JWT_RFT'),

];
