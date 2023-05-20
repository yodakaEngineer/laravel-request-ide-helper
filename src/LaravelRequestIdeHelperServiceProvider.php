<?php

declare(strict_types=1);

namespace Yodaka\LaravelRequestIdeHelper;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Yodaka\LaravelRequestIdeHelper\Console\GeneratorCommand;

class LaravelRequestIdeHelperServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GeneratorCommand::class,
            ]);
        }
    }
}
