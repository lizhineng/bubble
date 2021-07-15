<?php

namespace Zhineng\Bubble;

use Illuminate\Support\ServiceProvider;
use Zhineng\Bubble\MiniProgram\MiniProgramManager;

class BubbleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MiniProgramManager::class, function ($app) {
            return (new MiniProgramManager($app));
        });
    }

    public function boot()
    {
        $this->offerPublishing();
    }

    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bubble.php' => config_path('bubble.php'),
            ], 'bubble-config');
        }
    }
}
