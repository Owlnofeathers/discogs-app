<?php

namespace App\Http\Controllers;

use App\Services\DiscogsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DiscogsController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|View
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|string',
                'page' => 'int',
            ]
        );

        $collection = (new DiscogsService())->getCollection(
            $request->input('username'),
            $request->input('page')
        );

        if (empty($collection)) {
            return redirect()->back()->withErrors(
                ['message' => $collection['message'] ?? 'User does not exist or may have been deleted.']
            );
        }

        return view('home', $collection);
    }
}
