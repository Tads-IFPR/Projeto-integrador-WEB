<div>
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
        let overlay;

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
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'drop-overlay';
                overlay.style.position = 'fixed';
                overlay.style.top = 0;
                overlay.style.left = 0;
                overlay.style.width = '100vw';
                overlay.style.height = '100vh';
                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                overlay.style.zIndex = 1000;
                overlay.style.display = 'flex';
                overlay.style.justifyContent = 'center';
                overlay.style.alignItems = 'center';
                overlay.style.color = 'white';
                overlay.style.fontSize = '24px';
                overlay.innerText = 'Drop the files here';
                document.body.appendChild(overlay);
                overlay.addEventListener('dragleave', hideOverlay, false);
            }
        }

        function hideOverlay(e) {
            if (overlay) {
                document.body.removeChild(overlay);
                overlay = null;
            }
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
            console.log('teste')
            document.querySelector('#send-button').click();
        });
    });
</script>
