<?php
namespace Neftaio\Jmes;

use Illuminate\Support\ServiceProvider;

class JmesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = realpath(__DIR__ . '/../config/jmes.php');

        $this->publishes([$configPath => config_path('jmes.php')], 'config');
        $this->mergeConfigFrom($configPath, 'jmes');

        $this->commands([
            \Neftaio\Jmes\Console\JmesCompileCommand::class,
            \Neftaio\Jmes\Console\JmesClearCommand::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('jmes.runtime', function ($app) {
            $class = config('jmes.runtime');
            if ($class === \JmesPath\CompilerRuntime::class) {
                return new $class(config('jmes.compile_path'));
            } else {
                return new $class;
            }
        });

        $this->app->singleton('jmes', function ($app) {
            return new Jmes;
        });
        
        \Illuminate\Support\Collection::macro('search', function ($jmespath) {
            return Jmes::search($jmespath, $this->all());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'jmes',
            'jmes.runtime',
        ];
    }
}
