<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class DiscogsService
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.discogs.com';
    }

    /**
     * @param string $username
     * @param int|null $page
     * @return array
     */
    public function getCollection(string $username, int $page = null): array
    {
        $page = $page ? 'page=' . $page . '&' : '';
        $sort = 'sort=added&sort_order=desc&';

        $collection = Http::withHeaders($this->getHeaders())
            ->get($this->endpoint . '/users/' . $username . '/collection/folders/0/releases?' . $sort . $page . 'per_page=15');

        if ($collection->successful()) {
            if (auth()->user()->discogs_username !== strtolower($username)) {
                auth()->user()->update(
                    [
                        'discogs_username' => strtolower($username)
                    ]
                );
            }

            return $collection->json();
        }

        return [];
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
