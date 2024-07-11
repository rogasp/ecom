<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ImageView extends Component
{
    public $url;
    public $width;
    public $height;

    public function mount($url, $width, $height)
    {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }

    public function render()
    {

        return view('livewire.image-view');
    }
}
