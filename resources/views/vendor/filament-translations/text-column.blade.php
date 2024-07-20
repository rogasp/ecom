<div class="my-4">
    @if(is_array($getState()))
        <div>
            @foreach($getState() as $key => $item)
                <div class="flex justify-start gap-4 my-2">
                    <div class="border dark:border-gray-700 rounded-full" style="padding-left: 10px; padding-right: 10px">
                        {{--  Refactored code to get locale label  --}}
                            <?php
                            $localeLabel = collect(config('filament-translations.locals'))->first(function ($locale) use ($key) {
                                return $locale['flag'] === $key;
                            })['label'] ?? $key;

                            echo e($localeLabel);
                            ?>
                    </div>
                    <div>{{ $item }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
