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
    protected $signature = 'deploy';

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
        $dir = "~/deployments/kapax";
        
        $p = new Process("mkdir $dir -p; cd $dir; mkdir versions -p; cd versions;");
        $p->run();
        echo($p->getOutput());
        
        $p = new Process("git clone https://github.com/jrszapata/stanleys-url-shortener running; cd running");
        $p->run();
        echo($p->getOutput());
        
        $p = new Process("git log -1");
        $p->run();
        echo($p->getOutput());
        
    }
}
