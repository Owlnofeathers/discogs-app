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
            ->assertSessionHasErrors('message');
    }

    public function testGetCollectionSuccess()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $username = 'Owlsays';

        $response = $this->postJson(route('discogs.get_collection', ['username' => $username]))
            ->assertViewIs('home')
            ->assertViewHas('data');

        $user = $user->fresh();
        $this->assertSame(strtolower($username), $user->discogs_username);

        $pagination = $response->getOriginalContent()->getData()['data']['pagination'];
        $this->assertSame(1, $pagination['page']);
        $this->assertStringEndsWith('page=2', $pagination['urls']['next']);
    }

    public function testGetCollectionPagination()
    {
        $user = factory(User::class)->create(
            [
                'discogs_username' => 'Owlsays'
            ]
        );
        $this->be($user);

        $page = 10;

        $response = $this->postJson(
            route(
                'discogs.get_collection',
                [
                    'username' => $user->discogs_username,
                    'page' => $page,
                ]
            )
        )
            ->assertViewIs('home')
            ->assertViewHas('data');

        $pagination = $response->getOriginalContent()->getData()['data']['pagination'];
        $this->assertSame($page, $pagination['page']);
        $this->assertStringEndsWith('page=11', $pagination['urls']['next']);
        $this->assertStringEndsWith('page=9', $pagination['urls']['prev']);
    }
}
