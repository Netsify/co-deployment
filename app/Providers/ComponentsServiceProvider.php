<?php

namespace App\Providers;

use App\View\Components\Facilities\FacilityPreview;
use App\View\Components\Facilities\ProposalForm;
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
        Blade::component(ProposalForm::class, 'proposal-form');
        Blade::component(FacilityPreview::class, 'facility-preview');
    }
}
