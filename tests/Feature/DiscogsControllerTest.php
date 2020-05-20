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

        $response = $this->getJson(route('discogs.get_collection', ['username' => $this->faker->userName]))
            ->assertNotFound();

        $this->assertSame('User does not exist or may have been deleted.', $response->json()['message']);
    }

    public function testGetCollectionSuccess()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->getJson(route('discogs.get_collection', ['username' => 'Owlsays']))
            ->assertOk();

        $this->assertArrayHasKey('releases', $response->json());
    }
}
