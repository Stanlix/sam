<?php

namespace App\Listeners;

use App\Events\DeploymentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class StartAppDeployment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DeploymentCreated  $event
     * @return void
     */
    public function handle(DeploymentCreated $event)
    {
        Artisan::call('deploy', [
            'appname' => $event->deployment->app->name,
            'branch' => $event->deployment->branch,
            'hash' => $event->deployment->hash,
        ]);
    }
}
