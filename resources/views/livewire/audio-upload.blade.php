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

    <input type="file" id="fileElem" wire:model="file" style="display: none;" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.body;
        const fileInput = document.getElementById('fileElem');
        let overlay;

        // Previne o comportamento padrão do navegador para arrastar e soltar
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Adiciona a classe highlight ao arrastar o arquivo sobre a área de drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, showOverlay, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, hideOverlay, false);
        });

        // Lida com o evento de drop
        dropArea.addEventListener('drop', handleDrop, false);

        function showOverlay(e) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'drop-overlay';
                overlay.style.position = 'fixed';
                overlay.style.top = 0;
                overlay.style.left = 0;
                overlay.style.width = '100%';
                overlay.style.height = '100%';
                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                overlay.style.zIndex = 1000;
                overlay.style.display = 'flex';
                overlay.style.justifyContent = 'center';
                overlay.style.alignItems = 'center';
                overlay.style.color = 'white';
                overlay.style.fontSize = '24px';
                overlay.innerText = 'Solte o arquivo aqui';
                document.body.appendChild(overlay);
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
            [...files].forEach(file => {
                if (file.type.startsWith('audio/')) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                    // Trigger change event to inform Livewire
                    fileInput.dispatchEvent(new Event('change'));
                } else {
                    alert('Por favor, envie um arquivo de áudio.');
                }
            });
        }
    });
</script>
