<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Playlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_public',
        'cover_path',
        'cover_disk',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_public' => 'boolean',
    ];

    public function audios(): BelongsToMany
    {
        return $this->belongsToMany(Audio::class,  'audio_playlist');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function shareds(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shareds');
    }

    public function cover()
    {
        return Storage::disk($this->cover_disk)->get($this->cover_path);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCurrentUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
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

    public function scopeMostLiked($query, $timePeriod = null)
    {
        $timeFrame = match ($timePeriod) {
            'day' => Carbon::now()->subDay(),
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'year' => Carbon::now()->subYear(),
            default => null,
        };

        return $query->withCount(['likes' => function ($query) use ($timeFrame) {
            if ($timeFrame) {
                $query->where('playlist_user.created_at', '>=', $timeFrame);
            }
        }])->orderBy('likes_count', 'desc');
    }

    public function isCurrentUserOwner(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->id === auth()->user()->id,
        );
    }
}
