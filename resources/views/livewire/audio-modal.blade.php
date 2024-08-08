<div>
    @if($showModal)
    <div class="modal fade show" id="add-rem-{{ $playlistId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;" background-color="black">
        <div class="modal-dialog" background-color="black">
            <div class="modal-content" background-color="black">
                <div class="modal-header" background-color="black">
                    <h5 class="modal-title" id="exampleModalLabel">Add to Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ ($playlistId) }}</p>
                    <h1>MODAL DO CARALHO, ESSA PORRA FUNCINOU????</h1>
                    @foreach($audios as $audio)
                        <div wire:click="addAudio({{ $audio->id }}, {{ $playlistId }})">
                            
                            <livewire:add-remove-audio :audio="$audio" :key="$audio->id" :playlistId="$playlistId" class="mt-3"/>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

