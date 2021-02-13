<?php

namespace App\View\Components\Facilities;

use App\Models\Facilities\Facility;
use Illuminate\View\Component;

/**
 * Превью объекта инфраструктуры
 *
 * Class FacilityPreview
 * @package App\View\Components\Facilities
 */
class FacilityPreview extends Component
{
    /**
     * @var Facility
     */
    public $facility;

    /**
     * @var bool
     */
    public $showCompatibilityLevel;

    /**
     * @var null|int
     */
    public $facilityForComparison;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Facility $facility, bool $showCompatibilityLevel = false, $facilityForComparison = null)
    {
        $this->facility = $facility;
        $this->showCompatibilityLevel = $showCompatibilityLevel;
        $this->facilityForComparison = $facilityForComparison;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.facilities.facility-preview');
    }
}
