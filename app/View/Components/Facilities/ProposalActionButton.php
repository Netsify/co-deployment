<?php

namespace App\View\Components\Facilities;

use App\Models\Facilities\Proposal;
use Illuminate\View\Component;

/**
 * Кнопки ответа по входящему предложению
 *
 * Class ProposalActionButton
 * @package App\View\Components\Facilities
 */
class ProposalActionButton extends Component
{
    /**
     * Объект предложения
     *
     * @var Proposal
     */
    public $proposal;

    public $route;

    public $class;

    public $caption;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Proposal $proposal, $route, $class, $caption)
    {
        $this->proposal = $proposal;
        $this->route    = $route;
        $this->class    = $class;
        $this->caption  = $caption;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.facilities.proposal-action-button');
    }
}
