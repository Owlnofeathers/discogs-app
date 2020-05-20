<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscogsController extends Controller
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.discogs.com';
    }

    /**
     * @param string $username
     * @return array
     */
    public function index(string $username): array
    {
        $collection = Http::withHeaders($this->getHeaders())
            ->get($this->endpoint . '/users/' . $username . '/collection/folders/0/releases');

        if ($collection->successful()) {
            return $collection->json();
        }

        abort(404, $collection->json()['message']);
    }

    /**
     * @return array
     */
    private function getHeaders(): array
    {
        $key = config('services.discogs.key');
        $secret = config('services.discogs.secret');
        return [
            'Authorization: ' => 'Discogs ' . 'key=' . $key . ', secret=' . $secret,
            'User-Agent' => 'AdamsDiscogsApp/1.0',
        ];
    }
}
