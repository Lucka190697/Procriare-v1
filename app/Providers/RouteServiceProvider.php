<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->mapAjaxRoutes();
        $this->mapAuthenticatedWebRoutes();
        $this->mapPaginationRoutes();
        $this->mapUnauthenticatedWebRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }


    protected function mapAuthenticatedWebRoutes()
    {
        Route::middleware('web', 'auth', 'verified')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/authenticated.php'));
    }

    protected function mapUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/unauthenticated.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware('web', 'auth')
            ->namespace($this->namespace)
            ->prefix('ajax')
            ->group(base_path('routes/web/ajax.php'));
    }

    protected function mapPaginationRoutes()
    {
        Route::middleware('web', 'auth')
            ->namespace($this->namespace)
            ->prefix('pagination')
            ->group(base_path('routes/web/pagination.php'));
    }


    protected function mapDefaultWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }



}
