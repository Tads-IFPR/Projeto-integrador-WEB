<?php

namespace App\Http\Repositories;

use App\Models\Audio;
use Illuminate\Http\UploadedFile;

class AudioRepository
{
    public static function store(
        UploadedFile $uploadedFile,
        ?UploadedFile $cover = null,
        ?string $name = null,
        ?string $artist = null
    ) {
        $audio = [
            'name' => $name,
            'author' => $artist,
            'user_id' => auth()->id(),
        ];

        $audio['disk'] = config('filesystems.default');
        $audio['path'] = $uploadedFile->store('audios', $audio['disk']);

        $getID3 = new \getID3;
        $file = $getID3->analyze(storage_path('app') . '/' .$audio['path']);
        $audio['duration'] = ceil($file['playtime_seconds']);

        if ($cover) {
            $audio['cover_disk'] = config('filesystems.default');
            $audio['cover_path'] = $cover->store('covers', $audio['cover_disk']);
        }

        if (!$audio['name']) {
            $audio['name'] = $uploadedFile->getClientOriginalName();
            $audio['name'] = str_replace("." . $uploadedFile->getClientOriginalExtension(), '', $audio['name']);
        }

        return Audio::create($audio);
    }
}
