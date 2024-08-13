<?php

namespace App\Livewire;

use Livewire\Component;
use App\Constants\PreviewFileTypes;
use Illuminate\Support\Facades\Storage;

class ContentPreview extends Component
{
    public $fileUrl;
    public $fileType;

    public function mount($fileUrl)
    {
        $this->fileUrl = $this->getSafePath($fileUrl);
        $extension =  pathinfo($this->fileUrl, PATHINFO_EXTENSION);
        $this->fileType = PreviewFileTypes::getFileType($extension);
    }

    public function placeholder()
    {
        return view('components.spinner');
    }

    public function getSafePath($fileUrl)
    {
        return  Storage::url($fileUrl);

    }

    public function download()
    {
        $filePath = storage_path('app/' . $this->fileUrl);

        if (!file_exists($filePath)) {
            return response()->download($filePath);
        }
    }

    public function render()
    {
        return view('livewire.content-preview');
    }
}

