<?php

namespace App\Providers;

use App\View\Components\DeleteButtton;
use App\View\Components\Facilities\FacilityPreview;
use App\View\Components\Facilities\ProposalActionButton;
use App\View\Components\Facilities\ProposalForm;
use App\View\Components\InvalidFeedback;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component(DeleteButtton::class, 'delete-button');
        Blade::component(InvalidFeedback::class, 'invalid-feedback');
        Blade::component(ProposalForm::class, 'proposal-form');
        Blade::component(ProposalActionButton::class, 'proposal-action-button');
        Blade::component(FacilityPreview::class, 'facility-preview');
    }
}
