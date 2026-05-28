<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $required;
    public $placeholder;
    public $editable = "true";

    public function __construct(
        $name,
        $label,
        $type = 'text',
        $value = '',
        $required = false,
        $placeholder = ' ',
        $editable = "true"
    ) {
        info("Editable = $editable");
        $this->editable = $editable;
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = old($name, $value);
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.form.input');
    }
}