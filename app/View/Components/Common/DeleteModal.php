<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    public $id, $title, $message;
    /**
     * Create a new component instance.
     */
    public function __construct($id = 'deleteModal', $title = 'Delete Item', $message = 'Are you sure you want to delete this item?')
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.delete-modal');
    }
}
