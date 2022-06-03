<?php
namespace App\Console\Commands\Traits;

use Illuminate\Support\Facades\File;
use Str;

trait StubTrait
{
    protected function createFile($dummySource, $destinationPath)
    {
        $pluralModel = Str::plural(ucwords($this->getUpperModel()));
        $dummyRepository = $this->filesystem->get($dummySource);
        $repositoryContent = str_replace(['Dummy', 'Dummies'], [ucwords($this->getUpperModel()), $pluralModel], $dummyRepository);
        $this->filesystem->put($dummySource, $repositoryContent);
        $this->filesystem->copy($dummySource, $destinationPath);
        $this->filesystem->put($dummySource, $dummyRepository);
    }

    private function getUpperModel()
    {
        return ucwords($this->argument('model'));
    }

    public function createDirectory(string $path)
    {
        $path = app_path($path);
        
        if(!File::exists($path)){
            return File::makeDirectory($path, 0774, true, true);
        }
    }
}