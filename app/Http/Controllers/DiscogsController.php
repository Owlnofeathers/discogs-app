<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DiscogsController extends Controller
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.discogs.com';
    }

    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
        ]);

        $collection = Http::withHeaders($this->getHeaders())
            ->get($this->endpoint . '/users/' . $request->input('username') . '/collection/folders/0/releases');

        if ($collection->successful()) {
            return view('home', ['data' => $collection->json()]);
        }

        return redirect()->back()->with('message', [$collection->json()['message'] ?? 'User does not exist or may have been deleted.']);
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
