@extends ('layouts.app')

@section ('content')
    <div class="container-fluid">
    <div class="d-flex flex-column" id="audios">
        <div class="d-flex justify-content-between w-100">
            <h2 class="cfs-1 bolder">Musics</h2>
            <div class="d-flex w-100 wrap">
                @foreach ($audios as $audio)
                    <livewire:add-remove-audio :audio="$audio" :key="$audio->id" class="mt-3"/>
                @endforeach
            </div>
        </div>
    </div>
@endsection