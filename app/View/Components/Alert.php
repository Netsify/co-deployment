<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $message;

    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message, $class)
    {
        $this->message = $message;
        $this->class   = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
