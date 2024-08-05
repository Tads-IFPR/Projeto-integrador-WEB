@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <livewire:audio-upload />

        <div class="d-flex flex-column w-100">
            <div class="d-flex flex-column" id="playlists">
                <div class="d-flex justify-content-between w-100">
                    <h2 class="cfs-1 bolder">Playlists</h2>
                    <a href="{{ route('playlist.create') }}" class="button-default px-4 py-1" wire:navigate>New</a>
                </div>
                <div class="d-flex w-100 wrap">
                    @foreach ($playlists as $playlist)
                        <livewire:playlist-card :$playlist :key="$playlist->id" class="mt-3" />
                    @endforeach
                </div>
            </div>


            <livewire:home.audios />

        </div>

    </div>

@endsection

@push('styles')
    <style>
        #playlists {
            height: 30vh;
            overflow: auto;
        }

        #audios {
            height: 70vh;
        }

        .wrap {
            flex-wrap: wrap;
        }

        .audio-card {
            width: 20%;
            min-width: 20%;
        }

        .playlist-card {
            width: 20%;
            min-width: 20%;
        }

        @media screen and (max-width: 800px) {
            .audio-card {
                width: 100%;
                min-width: 100%;
            }

            .playlist-card {
                width: 100%;
                min-width: 100%;
            }
        }


        /* MODAL */

        .modal {
            color: #212529;
        }

        .modal .modal-header .modal-title {
            font-size: 24px !important;
            color: #212529;
        }


        .modal button:hover {
            background-color: #13f2a1;  //var(--secondary);
        }

        .modal .modal-close .material-symbols-outlined {
            font-size: 18px !important;
        }

        .modal-share .modal-body input {
            border-radius: 5px 0 0 5px;
        }

        /* Estilo básico para a lista de sugestões */
        .autocomplete-suggestions {
            max-height: 200px;
            overflow-y: auto;
        }

        .autocomplete-suggestions.active{
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

    </style>
@endpush
