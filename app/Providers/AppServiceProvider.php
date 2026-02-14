<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Banner;
use App\Models\TaxRegulation;
use App\Observers\ActivityObserver;
use App\Observers\ArticleObserver;
use App\Observers\BannerObserver;
use App\Observers\TaxRegulationObserver;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        Article::observe(ArticleObserver::class);
        Activity::observe(ActivityObserver::class);
        Banner::observe(BannerObserver::class);
        TaxRegulation::observe(TaxRegulationObserver::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
