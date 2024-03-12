<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Audio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AudioController
 */
final class AudioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $audio = Audio::factory()->count(3)->create();

        $response = $this->get(route('audio.index'));

        $response->assertOk();
        $response->assertViewIs('audio.index');
        $response->assertViewHas('audio');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('audio.create'));

        $response->assertOk();
        $response->assertViewIs('audio.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AudioController::class,
            'store',
            \App\Http\Requests\AudioStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $path = $this->faker->word();
        $disk = $this->faker->word();
        $duration = $this->faker->numberBetween(-10000, 10000);
        $is_public = $this->faker->boolean();
        $user = User::factory()->create();

        $response = $this->post(route('audio.store'), [
            'name' => $name,
            'path' => $path,
            'disk' => $disk,
            'duration' => $duration,
            'is_public' => $is_public,
            'user_id' => $user->id,
        ]);

        $audio = Audio::query()
            ->where('name', $name)
            ->where('path', $path)
            ->where('disk', $disk)
            ->where('duration', $duration)
            ->where('is_public', $is_public)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $audio);
        $audio = $audio->first();

        $response->assertRedirect(route('audio.index'));
        $response->assertSessionHas('audio.id', $audio->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $audio = Audio::factory()->create();

        $response = $this->get(route('audio.show', $audio));

        $response->assertOk();
        $response->assertViewIs('audio.show');
        $response->assertViewHas('audio');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $audio = Audio::factory()->create();

        $response = $this->get(route('audio.edit', $audio));

        $response->assertOk();
        $response->assertViewIs('audio.edit');
        $response->assertViewHas('audio');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AudioController::class,
            'update',
            \App\Http\Requests\AudioUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $audio = Audio::factory()->create();
        $name = $this->faker->name();
        $path = $this->faker->word();
        $disk = $this->faker->word();
        $duration = $this->faker->numberBetween(-10000, 10000);
        $is_public = $this->faker->boolean();
        $user = User::factory()->create();

        $response = $this->put(route('audio.update', $audio), [
            'name' => $name,
            'path' => $path,
            'disk' => $disk,
            'duration' => $duration,
            'is_public' => $is_public,
            'user_id' => $user->id,
        ]);

        $audio->refresh();

        $response->assertRedirect(route('audio.index'));
        $response->assertSessionHas('audio.id', $audio->id);

        $this->assertEquals($name, $audio->name);
        $this->assertEquals($path, $audio->path);
        $this->assertEquals($disk, $audio->disk);
        $this->assertEquals($duration, $audio->duration);
        $this->assertEquals($is_public, $audio->is_public);
        $this->assertEquals($user->id, $audio->user_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $audio = Audio::factory()->create();

        $response = $this->delete(route('audio.destroy', $audio));

        $response->assertRedirect(route('audio.index'));

        $this->assertSoftDeleted($audio);
    }
}
