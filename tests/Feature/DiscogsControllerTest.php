<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiscogsControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testGetCollectionFailsNoUser()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        // test a discogs username that definitely doesnt exist
        $this->postJson(route('discogs.get_collection', ['username' => 'aa']))
            ->assertRedirect()
            ->assertSessionHas('message');
    }

    public function testGetCollectionSuccess()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->postJson(route('discogs.get_collection', ['username' => 'Owlsays']))
            ->assertViewIs('home')
            ->assertViewHas('data');
    }
}
