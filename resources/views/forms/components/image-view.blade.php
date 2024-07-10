<!-- resources/views/forms/components/image-view.blade.php -->
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :width="$viewData('width')"
    :height="$viewData('height')"
    :url="$viewData('url')"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <img
            src="{{ $viewData['url'] }}"
            alt="Bild"
            style="width: {{ $viewData['width'] }}px; height: {{ $viewData['height'] }}px;"
            class="max-w-xs h-auto"
        />
    </div>
</x-dynamic-component>
