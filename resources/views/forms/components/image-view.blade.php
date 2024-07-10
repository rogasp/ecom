<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :width="$width"
    :height="$height"
    :url="$url"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <img
            src="{{ $url }}"
            alt="Bild"
            style="width: {{ $width }}px; height: {{ $height }}px;"
            class="max-w-xs h-auto"
        />
    </div>
</x-dynamic-component>
