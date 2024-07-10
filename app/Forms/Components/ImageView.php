<?php

namespace App\Forms\Components;

use Filament\Forms\Components\ViewField;

class ImageView extends ViewField
{
    protected string $view = 'forms.components.image-view';

    public function width(int $width): self
    {
        return $this->viewData(['width' => $width]);
    }

    public function height(int $height): self
    {
        return $this->viewData(['height' => $height]);
    }

    public function url(string $url): self
    {
        return $this->viewData(['url' => $url]);
    }
}
