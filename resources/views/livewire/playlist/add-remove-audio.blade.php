<div class="add-remove-audio d-flex justify-content-between px-1 {{$class}}"
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <img width="50px" src="{{ route('audio.show.image', $audio) }}" class="h-100" alt="Audio cover image">
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100" id="add-img">
        <h3 class="name">{{ $audio->name }}</h3>
        <h4>{{ $audio->author }}</h4>
    </div>
    <div class="d-flex align-items-center" >
        <form id="add-audio-form" action="{{ route('addAudio') }}" method="POST" class="add-form me-2">
            @csrf
            <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
            <input type="checkbox" name="selected_audios[]" value="{{ $audio->id }}">
            <button type="submit">
                <span class="material-symbols-outlined">
                    add
                </span>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('submit-button').addEventListener('click', function(e) {
            e.preventDefault();

            var form = document.getElementById('add-audio-form');
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Áudio adicionado com sucesso!');
                } else {
                    alert('Ocorreu um erro ao adicionar o áudio.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao adicionar o áudio.');
            });
        });
    });
</script>