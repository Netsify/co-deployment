<?php

namespace App\View\Components\Facilities;

use App\Models\Facilities\Facility;
use Illuminate\View\Component;

class ProposalForm extends Component
{
    /**
     * Объект отправителя
     *
     * @var
     */
    public $senderFacility;

    /**
     * Объект получателя
     *
     * @var
     */
    public $receiverFacility;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Facility $senderFacility, Facility $receiverFacility)
    {
        $this->senderFacility = $senderFacility;
        $this->receiverFacility = $receiverFacility;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.facilities.proposal-form');
    }
}
