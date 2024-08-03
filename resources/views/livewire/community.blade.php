<div class="container-fluid p-0">
    <main class="w-100 border-bottom px-3 pb-3">
        <h1 class="text-effect mb-4">BEST PLAYLIST<br>IN ONE LOCATION</h1>
        <div id="filters">
            <div class="filter-option" wire:click="filterMostLiked('month')">
                MOST POPULAR (MONTH)
            </div>
            <div class="filter-option" wire:click="filterMostLiked('year')">
                MOST POPULAR (YEAR)
            </div>
            <div class="filter-option" wire:click="filterMostLiked('week')">
                MOST POPULAR (WEEK)
            </div>
            <div class="filter-option" wire:click="filterMostLiked('day')">
                MOST POPULAR (DAY)
            </div>
        </div>
    </main>
    <div class="d-flex flex-column w-100 px-3 pt-3">
        <div class="d-flex flex-column" id="playlists">
            <div class="d-flex justify-content-between w-100">
                <h2 class="cfs-1 bolder">Playlists</h2>
            </div>
            <div class="d-flex w-100 wrap">
                @if (!$isLoading)
                    @foreach ($playlists as $playlist)
                        <livewire:playlist-card :$playlist :key="$playlist->id" class="mt-3"/>
                    @endforeach
                @else
                    <div class="w-100 d-flex justify-content-center">
                        <div class="loader"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .loader {
            border: 16px solid var(--primary);
            border-top: 16px solid transparent;
            border-radius: 50%;
            animation: spin 2s linear infinite;
            width: 7rem;
            height: 7rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #filters {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding-right: 1rem;
            padding-left: 1rem;
        }

        .filter-option {
            color: var(--primary);
            padding: 1.8rem 1rem;
            background-color: var(--dark-gray);
            border-radius: 1rem;
            font-weight: bolder;
            font-size: .9rem;
            cursor: pointer;
            transition: all ease-out 150ms;
        }

        .filter-option:hover {
            box-shadow: -.3rem .3rem var(--primary);
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
@endpush
