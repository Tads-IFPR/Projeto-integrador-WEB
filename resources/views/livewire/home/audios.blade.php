<div class="d-flex flex-column" id="audios">
    <div class="d-flex justify-content-between w-100">
        <h2 class="cfs-1 bolder">Musics</h2>
        <a href="{{route('audio.create')}}" class="button-default px-4 py-1" wire:navigate>New</a>
    </div>
    <div class="d-flex w-100 wrap">
        @foreach ($audios as $audio)
            <livewire:audio-card :$audio :key="$audio->id" class="mt-3"/>
        @endforeach
    </div>
</div>
