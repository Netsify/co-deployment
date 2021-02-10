<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusSelect extends Component
{
    /**
     * @var
     */
    public $proposal;

    /**
     * @var
     */
    public $route;

    /**
     * @var
     */
    public $statuses;

    /**
     * Create a new component instance.
     *
     * @param $statuses
     * @param $proposal
     * @param $route
     */
    public function __construct($statuses, $proposal, $route)
    {
        $this->statuses = $statuses;
        $this->proposal = $proposal;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.status-select');
    }
}
