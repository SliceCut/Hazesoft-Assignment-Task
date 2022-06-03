<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\StubTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DomainFactoryCommand extends Command
{
    use StubTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-factory {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate domain factory out of the box';

    protected $filesystem;

    protected $modelname;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $upperModel = $this->getUpperModel();
            $path = "Domain/Factories";

            $this->createDirectory($path);

            $this->createFile(
                app_path('Console/Stubs/DummyDomainFactory.stub'),
                app_path("{$path}/{$upperModel}Factory.php")
            );

            $this->info($this->argument('model').' Objectvalue generated successfully');
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
