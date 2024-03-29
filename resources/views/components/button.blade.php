<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button-default']) }}>
    {{ $slot }}
</button>
