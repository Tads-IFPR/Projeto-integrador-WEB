<div>
    <div wire:loading.class="show" wire:target="files" id="uploading">
        <div class="loader"></div>
        <h1>Uploading...</h1>
    </div>
    <div id="drop-overlay">
        <h1>Drag files to upload</h1>
        <img src="/imgs/green-arrow.png" alt="A green arrow pointed to top" id="arrow-upload">
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" id="drop-zone" style="display: none">
        <input type="file" multiple id="fileElem" wire:model="files"/>
        <button type="submit" id="send-button"></button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.body;
        const fileInput = document.getElementById('fileElem');
        var overlay = document.getElementById('drop-overlay');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, showOverlay, false);
        });

        ['drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, hideOverlay, false);
        });

        dropArea.addEventListener('drop', handleDrop, false);

        function showOverlay(e) {
            if (!overlay.classList.contains('add')) {
                overlay.classList.add('show');
                document.getElementsByTagName('body')[0].classList.add('remove-scroll');
                overlay.addEventListener('dragleave', hideOverlay, false);
            }
        }

        function hideOverlay(e) {
            overlay.classList.remove('show')
            document.getElementsByTagName('body')[0].classList.remove('remove-scroll');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            handleFiles(files);
        }

        function handleFiles(files) {
            fileInput.files = files;
            var event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }

        Livewire.on('fileProcessed', () => {
            document.querySelector('#send-button').click();
        });
    });
</script>

@push('styles')
<style>
    #drop-overlay,
    #uploading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: none;
        font-size: 24px;
    }

    #uploading h1 {
        color: var(--white);
        font-weight: bolder;
        margin-top: .5rem;
    }

    #drop-overlay {
        outline:.5rem dashed var(--primary);
        outline-offset:-1.5rem;
    }

    #drop-overlay h1 {
        color: var(--white);
        background-color: var(--secondary);
        border-radius: .5rem;
        font-weight: bolder;
        padding: 1rem 3rem;
    }

    #drop-overlay.show,
    #uploading.show {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
    }

    #arrow-upload {
        animation: bounce 2s infinite;
        margin-top: .7rem;
    }

    .remove-scroll {
        overflow: hidden;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(2rem);
        }
    }

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
</style>
@endpush
