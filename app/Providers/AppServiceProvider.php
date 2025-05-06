<?php

namespace App\Providers;

use App\Models\CoverageOption;
use App\Models\Destination;
use App\Models\Quote;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Repositories\CoverageOptionRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\QuoteRepository;
use App\Services\Pricing\Contracts\StandardQuoteInterface;
use App\Services\Pricing\PricingStrategyFactory;
use App\Services\QuoteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DestinationRepositoryInterface::class, function ($app) {
            return new DestinationRepository($app->make(Destination::class));
        });

        $this->app->singleton(CoverageOptionsRepositoryInterface::class, function ($app) {
            return new CoverageOptionRepository($app->make(CoverageOption::class));
        });

        $this->app->singleton(QuoteRepositoryInterface::class, function ($app) {
            return new QuoteRepository($app->make(Quote::class));
        });

        $this->app->singleton(StandardQuoteInterface::class, function ($app) {
            return new QuoteService(
                $app->make(DestinationRepositoryInterface::class),
                $app->make(CoverageOptionsRepositoryInterface::class),
                $app->make(QuoteRepositoryInterface::class),
                $app->make(PricingStrategyFactory::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
