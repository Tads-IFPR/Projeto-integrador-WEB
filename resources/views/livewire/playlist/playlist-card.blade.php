{{-- TODO Verificar CSS --}}
{{-- style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;" --}}
<div class="playlist-card d-flex justify-content-between px-1 {{ $class }}">


    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <a href="{{ route('playlist.show', $playlist->id) }}" class="play">
            <img width="50px" src="{{ route('playlist.show.image', $playlist) }}" class="h-100"
                alt="Playlist cover image">
        </a>
    </div>


    <div class="d-flex flex-column ps-3 pe-1 w-100">

        <button wire:click='play' class="play">
            <h3 class="name">{{ $playlist->name }}</h3>
        </button>

        <div>
            @if($playlist->audios->count() > 0)
                <span class="badge">{{ $playlist->audios->count() }} Audios</span>
            @endif
        </div>
    </div>
    <div class="d-flex align-items-center me-1">
        <span @class(['material-symbols-outlined like cursor-pointer', 'like-check' => $playlist->userLiked])
            wire:click="toggleLike"
        >
            favorite
        </span>
    </div>
    @if ($playlist->isCurrentUserOwner)
        <div class="options-playlist cursor-pointer"
            target="{{$playlist->id}}"
            wire:prevent
            onclick="toggleDropDownPlaylist(this.attributes.target.nodeValue)"
        >
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/>
            </svg>
        </div>
        <div id="backdrop-playlist-{{$playlist->id}}" target="{{$playlist->id}}" class="backdrop-playlist" style="display: none;"></div>
        <div id="option-playlist-{{$playlist->id}}" class="option-playlist flex-column align-items-center" style="display: none;">
            <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="d-flex align-items-center w-100 p-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center w-100">
                        <span class="material-symbols-outlined me-1">
                            delete
                        </span>
                        <span>Delete</span>
                    </div>
                </button>
            </form>
            <a href="{{ route('playlist.edit', $playlist->id) }}" wire:navigate class="d-flex align-items-center w-100 h-100 p-2 text-decoration-none">
                <div class="d-flex align-items-center w-100">
                    <span class="material-symbols-outlined me-1">
                        edit
                    </span>
                    <span>Edit</span>
                </div>
            </a>
            <div>
                <span class="material-symbols-outlined me-1">
                    add_circle
                </span>
                <span data-bs-toggle="modal" data-bs-target="#add-rem-{{ $playlist->id }}">
                    Add in this playlist
                </span>
            </div>
            <div wire:click="togglePrivacy">
                <span class="material-symbols-outlined me-1">
                    language
                </span>
                {{$playlist->is_public ? 'Turn private' : 'Turn public'}}
            </div>

            <a href="#" onclick="shareModal({{$playlist->id}}, '{{$playlist->name}}')">
                <div class="d-flex align-items-center w-100">
                    <span class="material-symbols-outlined me-1">
                        share
                    </span>
                    <span>
                        Share
                    </span>
                </div>
            </a>
        </div>



        <div class="modal fade" id="add-rem-{{ $playlist->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
            <div class="modal-dialog">

                <div class="modal-content" style="background-color: dark-gray;">

                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Music</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="background-color: #A9A9A9;">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h1 id="playlist-name">{{ $playlist->name }}</h1>

                        @if($audiosNotInPlaylist->isEmpty())
                            <p>No Audios to be added.</p>
                        @else
                            <form method="POST" action="{{ route('playlist.addAudio') }}"
                                target="hidden-iframe-{{ $playlist->id }}">
                                @csrf
                                <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                                <div class="container">
                                    <div class="row">
                                        @foreach($audiosNotInPlaylist as $audio)
                                            <div class="col-md-6 mb-3" id="card-add">
                                                <div class="card">
                                                    <div class="card-body d-flex">
                                                        <div class="d-flex justify-content-center align-items-center"
                                                            style="min-width: 50px">
                                                            <img src="{{ route('audio.show.image', $audio) }}"
                                                                class="h-100" alt="Audio cover image" id="img-audio">
                                                        </div>
                                                        <div class="d-flex flex-column ps-3 pe-1 w-100">
                                                            <h5 class="card-title mb-1" id="audio-name">
                                                                {{ $audio->name }}</h5>
                                                            <p class="card-text mb-2" id="author">
                                                                {{ $audio->author }} </p>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="audio_ids[]" value="{{ $audio->id }}"
                                                                    id="audio-{{ $audio->id }}">
                                                                <label class="form-check-label"
                                                                    for="audio-{{ $audio->id }}">
                                                                    Select
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center" style="height: 5%;">
                                            <button type="submit" class="btn btn-primary mt-3">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <iframe name="hidden-iframe-{{ $playlist->id }}" style="display:none;"
                            onload="closeModalOnSuccess('{{ $playlist->id }}')"></iframe>
                    </div>
                    <div class="modal-footer" style="background-color: black;">
                        <button type="button" id="close-modal-btn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>{{--  --}}


        <!-- Modal -->
        {{-- <div class="modal-share modal fade" id="share-modal-playlist-{{ $playlist->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">{{ $playlist->name }}</h5>

                        <button type="button" class="modal-close btn-close" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">
                                close
                            </span>
                        </button>
                    </div>


                    <div class="modal-body my-4 mb-5">

                        <span>Share with your friends!</span>

                        <div class="input-group">
                            <input type="text" class="form-control" id="users-autocomplete" autocomplete="false">

                            <button class="btn btn-outline-secondary" type="button" id="share-playlist">
                                <span class="material-symbols-outlined">
                                    share
                                </span>
                            </button>
                        </div>

                        <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>


                    </div>

                </div>
            </div>
        </div> --}}
    @endif
</div>

<script type="text/javascript">

    var userFriendId = "";

    document.addEventListener('DOMContentLoaded', function() {
        var processedPlaylists = new Set();

        window.addEventListener('audioAdded', function(event) {
            var playlistId = event.detail.playlistId;
            if (processedPlaylists.has(playlistId)) {
                console.log('Evento já processado para playlistId:', playlistId);
                return;
            }
            processedPlaylists.add(playlistId);

            var myModal = bootstrap.Modal.getInstance(document.getElementById('add-rem-' + playlistId));
            myModal.hide();

            var checkboxes = document.querySelectorAll('#add-rem-' + playlistId + ' input[type="checkbox"]:checked');
            console.log('Checkboxes encontrados:', checkboxes.length);
            checkboxes.forEach(function (checkbox) {
                var audioId = checkbox.value;
                console.log('Checkbox value:', audioId);
                var label = document.querySelector('label[for="audio-' + audioId + '"]');
                if (label) {
                    console.log('Label encontrado:', label);
                    label.textContent = 'Adicionado';

                    label.style.display = 'none';
                    label.offsetHeight;
                    label.style.display = '';
                }
                checkbox.disabled = true;
            });
        });

        var iframes = document.querySelectorAll('iframe');
        iframes.forEach(function(iframe) {
            iframe.onload = function() {
                var playlistId = iframe.getAttribute('name').split('-').pop();
                closeModalOnSuccess(playlistId);
            };
        });
    });

    function closeModalOnSuccess(playlistId) {
        var iframe = document.querySelector('iframe[name="hidden-iframe-' + playlistId + '"]');
        var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        if (iframeDoc.body.innerHTML.trim().includes('success')) {
            var event = new CustomEvent('audioAdded', { detail: { playlistId: playlistId } });
            window.dispatchEvent(event);
        }
    }


</script>

@push('styles')
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

        }

        .modal {
            color: #212529;
        }

        .modal .modal-header .modal-title {
            font-size: 24px !important;
            color: #212529;
        }


        .modal button:hover {
            background-color: #13f2a1; //var(--secondary);
        }

        .modal .modal-close .material-symbols-outlined {
            font-size: 18px !important;
        }

        .modal-share .modal-body input {
            border-radius: 5px 0 0 5px;
        }



        .playlist-card-add-button {
            background-color: #13f2a1; //var(--secondary);
            border: none;
            color: #212529;
            font-weight: bold;
        }


        /* Estilo básico para a lista de sugestões */
        .autocomplete-suggestions {
            max-height: 200px;
            overflow-y: auto;
        }

        .autocomplete-suggestions.active {
            border: 1px solid #ccc;
        }

        .autocomplete-suggestion {
            padding: 8px;
            cursor: pointer;
        }

        .autocomplete-suggestion:hover {
            border: 1px solid #ccc;
            background-color: #f0f0f0;
        }

        .card {
            background-color: #696969;
            color: white;
        }

        .card-title {
            font-size: 1.25rem;
        }

        .card-text {
            font-size: 1rem;
        }

        .form-check {
            margin-bottom: 0;
        }

        .form-check-input {
            margin-top: 0.5rem;
        }

        .form-check-label {
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #13F2A1;
            border-color: black;
        }


        #author {
            font-size: 0.8rem;
        }

        #audio-name {
            font-size: 1rem;
            padding: auto;
        }

        #img-audio {
            width: 10rem;
            height: 10rem;
            max-height: 10rem;
        }

        #card-add {
            margin-top: 0.2rem;
            height: 10rem;
            width: 30rem;
        }

    #playlist-name{
        font-size: 1.5rem;
        font-weight: bold;
    }


</style>

@endpush
