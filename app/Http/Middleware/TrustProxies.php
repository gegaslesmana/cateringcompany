<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Proxies yang dipercaya.
     * Gunakan '*' untuk semua proxy (development), atau daftar IP proxy untuk production.
     */
    protected $proxies = '*';

    /**
     * Header yang akan dipercaya untuk deteksi proxy.
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR 
                         | Request::HEADER_X_FORWARDED_HOST
                         | Request::HEADER_X_FORWARDED_PROTO
                         | Request::HEADER_X_FORWARDED_PORT
                         | Request::HEADER_X_FORWARDED_AWS_ELB;
}