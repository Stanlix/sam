<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        $dir = "storage/deployments/" . $this->argument('appname') . '/versions';
        $repoUrl = $this->argument('repourl'); 
        $this->exec("mkdir $dir -p; cd $dir");
        $this->exec("cd $dir; git clone $repoUrl running");
        $this->exec('cd $dir/running; composer install --no-dev');
        $commitHash = $this->exec('git log -1 --pretty=format:"%h"');
        $this->exec("cd $dir; mv running $commitHash");
        $this->exec("cd $dir/..; ln -s ./storage/deployments/$commitHash active");
        $this->exec("cd $dir/$commitHash; ln -s ../../.env .env");
    }

    protected function exec($cmd) 
    {
        $p = new Process($cmd);
        $p->run();
        echo ($p->getOutput());
        return $p->getOutput();
    }
}
