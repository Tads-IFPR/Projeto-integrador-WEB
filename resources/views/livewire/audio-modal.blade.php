<div>
    @if($showModal)
    <div class="modal fade show" id="add-rem-{{ $playlistId }}" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #1c1c1c; color: white;">
                <div class="modal-header" style="border-bottom: 1px solid #444;">
                    <h5 class="modal-title" id="exampleModalLabel">Add Audios to your Playlist</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    @if($audios->count() == 0)
                        <p>No audios to be added</p>
                    @else
                        @foreach($audios as $audio)
                            <livewire:add-remove-audio :audio="$audio" :key="$audio->id" :playlistId="$playlistId" class="mt-3"/>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer" style="border-top: 1px solid #444;">
                    @if($isPlaylistShow)
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Save Changes</button>
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Close</button>
                    @endif                
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

