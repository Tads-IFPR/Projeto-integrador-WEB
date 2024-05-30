<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        return $this->belongsToMany(Audio::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function shareds(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shareds');
    }
}
