<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Audio extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'disk',
        'author',
        'duration',
        'cover_path',
        'cover_disk',
        'is_public',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_public' => 'boolean',
        'user_id' => 'integer',
    ];

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'audio_playlist');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return Storage::disk($this->disk)->get($this->path);
    }

    public function cover()
    {
        return Storage::disk($this->cover_disk)->get($this->cover_path);
    }

    public function scopeCurrentUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }

    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->name, 0, 23),
        );
    }

    protected function restName(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->name, 23),
        );
    }

    public function next(array $ignoreIds = [])
    {
        return self::currentUser()
            ->when($ignoreIds,
                fn($q) => $q->whereNotIn('id', $ignoreIds)->inRandomOrder(),
                fn($q) => $q->where('id', '>', $this->id)->orderBy('id','asc')
            )->first();
    }

    public function previous()
    {
        return self::currentUser()->where('id', '<', $this->id)->orderBy('id','desc')->first();
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_public', true);
    }

    public function userLiked(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->likes()->where('user_id', auth()->user()->id)->exists(),
        );
    }

    public function isCurrentUserOwner(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->id === auth()->user()->id,
        );
    }
}
