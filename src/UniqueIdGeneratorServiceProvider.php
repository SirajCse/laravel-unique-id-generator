<?php namespace sirajcse\UniqueIdGenerator;

use Illuminate\Support\ServiceProvider;

class UniqueIdGeneratorServiceProvider extends ServiceProvider
{

    public function boot()
    {
    
    }

    
    public function register()
    {
        $this->app->make('sirajcse\UniqueIdGenerator\UniqueIdGenerator');
    }

}
