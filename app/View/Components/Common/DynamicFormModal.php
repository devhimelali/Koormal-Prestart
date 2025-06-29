<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicFormModal extends Component
{
    public $id;
    public $formId;
    public $title;
    public $submitText;
    /**
     * Create a new component instance.
     */
    public function __construct($id = 'dynamicModal', $formId = 'dynamicForm', $title = 'Form Title', $submitText = 'Save')
    {
        $this->id = $id;
        $this->formId = $formId;
        $this->title = $title;
        $this->submitText = $submitText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.dynamic-form-modal');
    }
}
