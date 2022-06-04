<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\StubTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DomainObjectValueCommand extends Command
{
    use StubTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-objectvalue {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate DTO object value out of box';

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
            $path = "Domain/ObjectValues";

            $this->createDirectory($path);

            $this->createFile(
                app_path('Console/Stubs/DummyObjectValue.stub'),
                app_path("{$path}/{$upperModel}ObjectValue.php")
            );

            $this->info($this->argument('model') . ' Objectvalue generated successfully');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
