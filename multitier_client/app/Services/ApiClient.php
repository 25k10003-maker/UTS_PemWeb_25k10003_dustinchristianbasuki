<?php

namespace App\Services;

use App\Exceptions\ApiUnauthorizedException;
use App\Exceptions\ApiUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Pembungkus HTTP client untuk memanggil REST API multitier_server.
 * Token disimpan di session client dan dikirim sebagai Bearer token.
 */
class ApiClient
{
    public function get(string $uri, array $query = []): Response
    {
        return $this->send('get', $uri, $query);
    }

    public function post(string $uri, array $data = []): Response
    {
        return $this->send('post', $uri, $data);
    }

    public function put(string $uri, array $data = []): Response
    {
        return $this->send('put', $uri, $data);
    }

    public function patch(string $uri, array $data = []): Response
    {
        return $this->send('patch', $uri, $data);
    }

    public function delete(string $uri, array $data = []): Response
    {
        return $this->send('delete', $uri, $data);
    }

    /**
     * @param  bool  $authenticated  false untuk endpoint publik (login/register)
     */
    public function send(string $method, string $uri, array $data = [], bool $authenticated = true): Response
    {
        try {
            $response = $this->request($authenticated)->{$method}(ltrim($uri, '/'), $data);
        } catch (ConnectionException $e) {
            throw new ApiUnavailableException($e->getMessage(), 0, $e);
        }

        if ($authenticated && $response->status() === 401) {
            throw new ApiUnauthorizedException(
                $response->json('message') ?? 'Sesi berakhir. Silakan login ulang.'
            );
        }

        return $response;
    }

    private function request(bool $authenticated): PendingRequest
    {
        $request = Http::baseUrl(config('pos_api.base_url'))
            ->acceptJson()
            ->asJson()
            ->timeout(config('pos_api.timeout'));

        if ($authenticated && session()->has('api_token')) {
            $request = $request->withToken(session('api_token'));
        }

        return $request;
    }
}
