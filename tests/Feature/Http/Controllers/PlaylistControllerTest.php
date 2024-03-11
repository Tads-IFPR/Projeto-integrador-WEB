<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlaylistController
 */
final class PlaylistControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $playlists = Playlist::factory()->count(3)->create();

        $response = $this->get(route('playlist.index'));

        $response->assertOk();
        $response->assertViewIs('playlist.index');
        $response->assertViewHas('playlists');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('playlist.create'));

        $response->assertOk();
        $response->assertViewIs('playlist.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlaylistController::class,
            'store',
            \App\Http\Requests\PlaylistStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $is_public = $this->faker->boolean();

        $response = $this->post(route('playlist.store'), [
            'name' => $name,
            'is_public' => $is_public,
        ]);

        $playlists = Playlist::query()
            ->where('name', $name)
            ->where('is_public', $is_public)
            ->get();
        $this->assertCount(1, $playlists);
        $playlist = $playlists->first();

        $response->assertRedirect(route('playlist.index'));
        $response->assertSessionHas('playlist.id', $playlist->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $playlist = Playlist::factory()->create();

        $response = $this->get(route('playlist.show', $playlist));

        $response->assertOk();
        $response->assertViewIs('playlist.show');
        $response->assertViewHas('playlist');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $playlist = Playlist::factory()->create();

        $response = $this->get(route('playlist.edit', $playlist));

        $response->assertOk();
        $response->assertViewIs('playlist.edit');
        $response->assertViewHas('playlist');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlaylistController::class,
            'update',
            \App\Http\Requests\PlaylistUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $playlist = Playlist::factory()->create();
        $name = $this->faker->name();
        $is_public = $this->faker->boolean();

        $response = $this->put(route('playlist.update', $playlist), [
            'name' => $name,
            'is_public' => $is_public,
        ]);

        $playlist->refresh();

        $response->assertRedirect(route('playlist.index'));
        $response->assertSessionHas('playlist.id', $playlist->id);

        $this->assertEquals($name, $playlist->name);
        $this->assertEquals($is_public, $playlist->is_public);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $playlist = Playlist::factory()->create();

        $response = $this->delete(route('playlist.destroy', $playlist));

        $response->assertRedirect(route('playlist.index'));

        $this->assertModelMissing($playlist);
    }
}
