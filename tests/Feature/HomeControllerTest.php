<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * If new user or user has no username saved, they should get the prompt to enter their username.
     *
     * @return void
     */
    public function testShowNoDiscogsUsername()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->getJson(route('home'))->assertOk()
            ->assertViewIs('home')
            ->assertSee('Enter Your Discogs Username');
    }

    /**
     * If user has discogs username previously saved, it should fetch their releases.
     *
     * @return void
     */
    public function testShowWithDiscogsUsername()
    {
        $user = factory(User::class)->create(
            [
                'discogs_username' => 'Owlsays'
            ]
        );
        $this->be($user);

        $this->getJson(route('home'))->assertOk()
            ->assertViewIs('home')
            ->assertViewHas('releases')
            ->assertViewHas('pagination')
            ->assertSee('Artist');
    }
}
