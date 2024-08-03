@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'py-1 ps-3']) }}>
        @foreach ((array) $messages as $message)
            <span class="d-block text-danger" style="font-size: .7rem; font-weight: bold;">{{ $message }}</span>
        @endforeach
    </div>
@endif
