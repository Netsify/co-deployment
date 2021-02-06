<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Facilities\Facility;
use App\Models\File;
use App\Models\Role;
use App\Policies\FacilityPolicy;
use App\Policies\KnowledgeBase\ArticlePolicy;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        File::class => ArticlePolicy::class,
        Facility::class =>FacilityPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('use-advanced-search', function (?User $user) {
            $role = optional($user)->role;
            return in_array(optional($role)->slug, [Role::ROLE_ICT_OWNER, Role::ROLE_ROADS_OWNER]);
        });
    }
}
