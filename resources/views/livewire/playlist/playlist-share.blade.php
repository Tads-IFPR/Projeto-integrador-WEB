<!-- Modal -->
<div class="modal-share modal fade" id="share-modal-playlist">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel"></h5>

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

            <div class="modal-share">
                @if($playlist?->shareds)
                    @foreach ($playlist?->shareds as $user)
                        <div class="d-flex justify-content-between">
                            <span>{{$user->name}}</span>
                            <button href="#" wire:click="removeShared({{$user->id}})" class="button-default px-4 py-1" id="delete-share">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>
                        </div>

                    @endforeach
                @endif

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    var share = {
        "playlistId" : "",
        "sharedUserId" : "",
    };

    function shareModal(playlistIdParam, playlistName){
        @this.newPlaylist(playlistIdParam);
        let modal = document.getElementById('share-modal-playlist');
        let title = document.querySelector('#share-modal-playlist .modal-title');
        share.playlistId = playlistIdParam;
        title.textContent = playlistName;
        modal = new bootstrap.Modal(modal);
        modal.show();

    }

    document.getElementById('users-autocomplete').addEventListener('input', function() {
    const query = this.value;

    if (query.length >= 3) {
        const playlistId = share.playlistId;

        // Obtenha os IDs dos usuários já compartilhados
        fetch(`/playlist/${playlistId}/shared-users`)
            .then(response => response.json())
            .then(sharedUserIds => {

                fetch(`/users/${query}`)
                    .then(response => response.json())
                    .then(resultJson => {

                        const suggestionsContainer = document.getElementById('autocomplete-suggestions');

                        // Filtrar usuários que já têm a playlist compartilhada
                        const filteredUsers = resultJson.filter(user => !sharedUserIds.includes(user.id));

                        if (filteredUsers.length > 0) {
                            suggestionsContainer.classList.add('active');
                        }

                        suggestionsContainer.innerHTML = '';
                        filteredUsers.forEach(user => {
                            const suggestion = document.createElement('div');
                            suggestion.classList.add('autocomplete-suggestion');

                            suggestion.textContent = user.name;

                            suggestion.addEventListener('click', () => {
                                document.getElementById('users-autocomplete').value = user.name;

                                share.sharedUserId = user.id;

                                suggestionsContainer.innerHTML = '';
                                suggestionsContainer.classList.remove('active');
                            });

                            suggestionsContainer.appendChild(suggestion);
                        });
                    });
            });
    } else {
        document.getElementById('autocomplete-suggestions').innerHTML = '';
    }
});


document.getElementById('share-playlist').addEventListener('click', function() {
console.log(share);

fetch(`/playlist/` + share.playlistId + `/share`, {
    method: 'post',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content')
    },
    body: JSON.stringify({
        sharedUserId: share.sharedUserId,
        playlistId: share.playlistId
    })


}).then((response) => {
    return response.json();
}).then(response => {

    console.log(response);


    if (response.status == 200) {
        alert(response.message);
        document.getElementById('users-autocomplete').value = '';
    } else {
        alert('Error sharing playlist');
    }
});

document.addEventListener('livewire:load', function () {
    Livewire.on('refreshModal', () => {
        $('shareModal').modal('show');

    });
});


});
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

        .autocomplete-suggestion.active {
            background-color: #13f2a1; //var(--secondary);
            color: #fff;
        }

    </style>
@endpush
