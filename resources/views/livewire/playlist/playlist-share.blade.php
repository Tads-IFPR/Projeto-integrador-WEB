<!-- Modal -->
<div class="modal-share modal fade" id="share-modal-playlist">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel"></h5>
                Share with your friends!
                <button type="button" class="modal-close btn-close" data-bs-dismiss="modal">
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>
            </div>


            <div class="modal-body">

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

            <div class="modal-share" id="modal-share" >
                <span class="title-share">Friends already shared!</span>
                @if ($playlist?->shareds)
                    @foreach ($playlist?->shareds as $user)
                        <div class="d-flex justify-content-between">
                            <span>{{ $user->name }}</span>
                            <button onclick="removeShared({{ $user->id}}, this)"

                                class="button-delete px-4 py-1" id="delete-share">
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
        "playlistId": "",
        "sharedUserId": "",
    };

    function removeShared(sharedUserId, element) {
        fetch(`/playlist/${share.playlistId}/remove-shared/${sharedUserId}`, {
            method: 'delete',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            }
        }).then((response) => {
            if (response.status == 200) {
                element.parentNode.remove();
            }else{
                alert('Error removing shared user');
            }
        });
    }

    var modal = null;

    function shareModal(playlistIdParam, playlistName) {
        @this.newPlaylist(playlistIdParam);
        let title = document.querySelector('#share-modal-playlist .modal-title');
        share.playlistId = playlistIdParam;
        title.textContent = playlistName;
        let modalElement = document.getElementById('share-modal-playlist');
        modal = new bootstrap.Modal(modalElement);
        modal.show();

    }

    document.getElementById('users-autocomplete').addEventListener('input', function() {
        const query = this.value;

        if (query.length >= 2) {
            const playlistId = share.playlistId;

            // Obtenha os IDs dos usuários já compartilhados
            fetch(`/playlist/${playlistId}/shared-users`)
                .then(response => response.json())
                .then(sharedUserIds => {

                    fetch(`/users/${query}`)
                        .then(response => response.json())
                        .then(resultJson => {

                            const suggestionsContainer = document.getElementById(
                                'autocomplete-suggestions');

                            // Filtrar usuários que já têm a playlist compartilhada
                            const filteredUsers = resultJson.filter(user => !sharedUserIds.includes(user
                                .id));

                            if (filteredUsers.length > 0) {
                                suggestionsContainer.classList.add('active');
                            }

                            suggestionsContainer.innerHTML = '';
                            filteredUsers.forEach(user => {
                                const suggestion = document.createElement('div');
                                suggestion.classList.add('autocomplete-suggestion');

                                suggestion.textContent = user.name;

                                suggestion.addEventListener('click', () => {
                                    document.getElementById('users-autocomplete')
                                        .value = user.name;

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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                sharedUserId: share.sharedUserId,
                playlistId: share.playlistId
            })

        }).then(response => {
            modal.hide();
            console.log('cheguei aki', modal);
        });

    });

    document.addEventListener('livewire:load', function() {
        window.livewire.on('sharedUpdated', () => {
            fetch(`/playlist/${share.playlistId}/shared-users`)
                .then(response => response.json())
                .then(sharedUserIds => {

                    fetch(`/users/${query}`)
                        .then(response => response.json())
                        .then(resultJson => {

                            const suggestionsContainer = document.getElementById(
                                'autocomplete-suggestions');

                            const filteredUsers = resultJson.filter(user => !sharedUserIds
                                .includes(user
                                    .id));

                            if (filteredUsers.length > 0) {
                                suggestionsContainer.classList.add('active');
                            }

                            suggestionsContainer.innerHTML = '';
                            filteredUsers.forEach(user => {
                                const suggestion = document.createElement('div');
                                suggestion.classList.add('autocomplete-suggestion');

                                suggestion.textContent = user.name;

                                suggestion.addEventListener('click', () => {
                                    document.getElementById(
                                            'users-autocomplete')
                                        .value = user.name;

                                    share.sharedUserId = user.id;

                                    suggestionsContainer.innerHTML = '';
                                    suggestionsContainer.classList.remove(
                                        'active');
                                });

                                suggestionsContainer.appendChild(suggestion);
                                console.log('sharedUpdated event received');
                            });

                        });
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

        .button-delete {
            background-color: red;
            color: #212529;
            font-weight: bold !important;
            border-radius: 5px !important;
            font-size: 8px !important;
            padding: 4px 8px !important;
        }

        .button-delete:hover {
            background-color: red !important;
            color: var(--gray) !important;
            border-radius: 5px !important;
            font-size: 8px !important;
            padding: 4px 8px !important;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5) !important;
        }

        .delete-share:hover {
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5) !important;
        }

        .modal {
            color: #212529;
        }

        .modal-share .modal-header {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 1.5rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom: none;
        }

        .modal-share .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .modal-share .modal-body {
            background-color: var(--dark-gray);
            padding: 2rem;
            color: var(--gray);
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .modal-share .input-group {
            margin-top: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid var(--white);
        }

        .modal-share .input-group input {
            border: none;
            border-radius: 0;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            background-color: var(--dark-gray);
            color: var(--white);
        }

        .modal-share .input-group button {
            background-color: rgba(215,215,215,1);
            color: var(--dark-gray);
            border: none;
        }

        .modal-share .input-group button:hover {
            background-color: var(--white);
            color: var(--dark);
        }

        .autocomplete-suggestions {
            background-color: var(--dark-gray);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
        }

        .autocomplete-suggestion {
            padding: 0.5rem 1rem;
            color: var(--white);
            transition: background-color 0.2s;
        }

        .autocomplete-suggestion:hover {
            background-color: var(--secondary);
            color: var(--dark);
        }

        .modal-share .d-flex {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--dark-gray);
        }

        .modal-share .button-delete {
            background-color: var(--danger);
            color: var(--white);
            border-radius: 0.25rem;
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
            border: none;
            transition: background-color 0.2s;
        }

        .modal-share .button-delete:hover {
            background-color: var(--dark-gray);
            color: var(--danger);
        }

        .modal button:hover {
            background-color: #13f2a1;
        }

        .modal .modal-close .material-symbols-outlined {
            font-size: 16px !important;
            color: var(--white);
        }

        .modal-share .modal-body input {
            border-radius: 5px 0 0 5px;
        }

        .modal-share {
            margin-right: 15px;
            margin-left: 20px;
        }

        .playlist-card-add-button {
            background-color: #13f2a1;
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
            background-color: var#f0f0f0;
        }

        .autocomplete-suggestion.active {
            background-color: var(--secondary);
            color: #fff;
        }

        .modal-close:hover {
            background-color: var(--darkgray)!important;
            color: var(--white)!important;
            top: 0;
            right: 0;
            color: var(--white);
        }

        .modal-header {padding: ;
            font-size: 14px important;
            padding-left: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom: none;
        }

        .modal-content {
            background-color: var(--dark-gray);
            color: var(--white);
        }

        .title-share {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        #modal-share > :nth-child(n+3){
            border-top: 1px solid var(--gray) !important;
        }

       .btn-outline-secondary {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush
