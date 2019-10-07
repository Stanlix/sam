<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DeployAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy
        {appname : Name of the application}
        {repourl : Url of the repo to be deployed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $appBaseDir = env('DEPLOYMENT_DIR', base_path('storage/deployments')) . '/' . $this->argument('appname');
            $dir = $appBaseDir . '/versions';
            $repoUrl = $this->argument('repourl'); 
            
            $this->exec("mkdir $dir -p; cd $dir");
            
            if(file_exists("$dir/running")) {
                $this->exec("rm $dir/running -rf");
            }
            $this->exec("cd $dir; git clone $repoUrl running");
            
            $this->exec("cd $dir/running; composer install --no-dev");
            
            $commitHash = $this->exec("cd $dir/running; git log -1 --pretty=format:\"%h\"");
            if (file_exists("$dir/$commitHash")) {
                $this->exec("rm $dir/$commitHash -rf");
            }
            $this->exec("cd $dir; mv running $commitHash");

            $this->exec("ln -fns $dir/$commitHash $appBaseDir/active");
            
            if (!file_exists("$appBaseDir/storage")) {
                $this->exec("mv $dir/$commitHash/storage $appBaseDir/");
            } else {
                $this->exec("rm -rf $dir/$commitHash/storage");
            }

            $this->exec("cd $dir/$commitHash; ln -s $appBaseDir/.env .env");
            $this->exec("cd $dir/$commitHash; ln -s $appBaseDir/storage storage");
        }
        catch (ProcessFailedException $e) {
            echo $e->getMessage();
        }
    }

    protected function exec($cmd) 
    {
        $p = new Process($cmd);
        $p->mustRun();
        echo ($p->getOutput());
        return $p->getOutput();
    }
}
