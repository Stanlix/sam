<?php

namespace App;

use App\Events\DeploymentCreated;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    
    public function deploy($branch, $hash = null)
    {
       $deployment = $this->deployments->insert([
           'branch' => $branch,
           'hash' => $hash,
       ]);
       DeploymentCreated::dispatch($deployment); 
    }
}
