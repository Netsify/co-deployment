<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class IconVerified extends Component
{
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new component instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->user->verified) {
            return view('components.icon-verified');
        }
    }
}
