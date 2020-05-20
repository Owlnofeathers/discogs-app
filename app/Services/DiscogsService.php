<?php


namespace App\Services;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

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
     * @return Application|Factory|RedirectResponse|View
     */
    public function getCollection(string $username, int $page = null)
    {
        $page = $page ? '&page=' . $page : '';

        $collection = Http::withHeaders($this->getHeaders())
            ->get($this->endpoint . '/users/' . $username . '/collection/folders/0/releases?perPage=50' . $page);

        if ($collection->successful() && auth()->user()->discogs_username !== strtolower($username)) {
            auth()->user()->update(
                [
                    'discogs_username' => strtolower($username)
                ]
            );

            return view('home', ['data' => $collection->json()]);
        }

        return redirect()->back()->withErrors(
            ['message' => $collection->json()['message'] ?? 'User does not exist or may have been deleted.']
        );
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
