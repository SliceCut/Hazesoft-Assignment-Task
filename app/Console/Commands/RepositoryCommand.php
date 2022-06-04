<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Traits\StubTrait;
use Illuminate\Filesystem\Filesystem;

class RepositoryCommand extends Command
{
    use StubTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate model and a base repository out of the box.';

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
            $path = "Domain/Repositories/{$upperModel}";

            if (!$this->filesystem->exists(app_path("Models/{$upperModel}.php"))) {
                $this->call('make:model', [
                    'name' =>  $upperModel,
                ]);
            }

            $this->createDirectory($path);

            $this->createFile(
                app_path('Console/Stubs/DummyRepository.stub'),
                app_path("{$path}/{$upperModel}Repository.php")
            );

            $this->createFile(
                app_path('Console/Stubs/DummyRepositoryInterface.stub'),
                app_path("{$path}/{$upperModel}RepositoryInterface.php")
            );
            $this->info($this->argument('model') . ' Repository and model generated successfully');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
