<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MakeCrud extends Command
{
    protected $signature = 'make:crud {name}';
    protected $description = 'Create Controller, Service, Repository and Interface';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        $this->createDirectories();
        $this->createController($name);
        $this->createService($name);
        $this->createRepository($name);
        $this->createInterface($name);
        $this->bindRepository($name);

        $this->info("CRUD layers for {$name} created successfully.");
    }

    private function createDirectories()
    {
        $paths = [
            app_path('Services'),
            app_path('Repositories'),
            app_path('Repositories/Contracts'),
        ];

        foreach ($paths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }
    }

    private function createController($name)
    {
        $varName = lcfirst($name);
        $path = app_path('Http/Controllers/web');

        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0755, true);
        }

        $content = <<<PHP
    <?php

    namespace App\Http\Controllers\web;

    use App\Http\Controllers\Controller;
    use App\Services\\{$name}Service;
    use Illuminate\Http\Request;
    use App\Models\\{$name};

    class {$name}Controller extends Controller
    {
        public function __construct(
            protected {$name}Service \${$varName}Service
        ) {}

        public function index()
        {
            \${$varName}s = \$this->{$varName}Service->getAllPosts();
            return view('pages.{$varName}s', compact('{$varName}s'));
        }

        // Page pour créer un nouveau post
        public function create()
        {
            return view('pages.create-{$varName}');
        }

        // Page pour éditer un post existant
        public function edit({$name} \${$varName})
        {
            return view('pages.create-{$varName}', compact('{$varName}'));
        }

        // Sauvegarde d'un nouveau post
        public function store(Request \$request)
        {
            \$data = \$request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'is_published' => 'boolean'
            ]);

            \$this->{$varName}Service->create(\$data);
            return redirect()->route('{$varName}.index');
        }

        // Mise à jour d'un post existant
        public function update(Request \$request, {$name} \${$varName})
        {
            \$data = \$request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'is_published' => 'boolean'
            ]);

            \$this->{$varName}Service->update(\${$varName}, \$data);

            return redirect()->route('{$varName}.index');
        }

        // Supprimer un post
        public function destroy({$name} \${$varName})
        {
            \$this->{$varName}Service->delete(\${$varName});
            return redirect()->route('{$varName}.index');
        }
    }
    PHP;

        \File::put("{$path}/{$name}Controller.php", $content);
    }


    private function createService($name)
    {
        $varName = lcfirst($name);
        $content = <<<PHP
<?php

namespace App\Services;

use App\Repositories\Contracts\\{$name}RepositoryInterface;
use App\Models\\{$name};

class {$name}Service
{
    public function __construct(
        protected {$name}RepositoryInterface \${$varName}Repository
    ) {}

    public function getAllPosts(){
        return \$this->{$varName}Repository->all();
    }

    public function find(int \$id): ?{$name}
    {
        return \$this->{$varName}Repository->find(\$id);
    }

    public function create(array \$data): {$name}
    {
        return \$this->{$varName}Repository->create(\$data);
    }

    public function update({$name} \${$varName}, array \$data): {$name}
    {
        return \$this->{$varName}Repository->update(\${$varName}, \$data);
    }

    public function delete({$name} \${$varName}): bool
    {
        return \$this->{$varName}Repository->delete(\${$varName});
    }
}
PHP;

        File::put(app_path("Services/{$name}Service.php"), $content);
    }

    private function createRepository($name)
    {
        $varName = lcfirst($name);
        $content = <<<PHP
<?php

namespace App\Repositories;

use App\Models\\{$name};
use App\Repositories\Contracts\\{$name}RepositoryInterface;

class Eloquent{$name}Repository implements {$name}RepositoryInterface
{
    public function create(array \$data): {$name}
    {
        return {$name}::create(\$data);
    }

     public function all()
    {
        return {$name}::orderBy('created_at', 'desc')->get();
    }

    public function find(int \$id): ?{$name}
    {
        return {$name}::find(\$id);
    }

     public function update(Post \${$varName}, array \$data): {$name}
    {
        \${$varName}->update(\$data);
        return \${$varName};
    }

     public function delete(Post \${$varName}): bool
    {
        return \${$varName}->delete();
    }
}
PHP;

        File::put(app_path("Repositories/Eloquent{$name}Repository.php"), $content);
    }

    private function createInterface($name)
    {
        $varName = lcfirst($name);
        $content = <<<PHP
<?php

namespace App\Repositories\Contracts;

use App\Models\\$name;

interface {$name}RepositoryInterface
{
    public function create(array \$data): {$name};

    public function all();

    public function find(int \$id): ?{$name};

    public function update({$name} \${$varName}, array \$data): {$name};

    public function delete({$name} \${$varName}): bool;
}
PHP;

        File::put(app_path("Repositories/Contracts/{$name}RepositoryInterface.php"), $content);
    }

    private function bindRepository($name)
    {
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');

        if (!File::exists($providerPath)) {
            Artisan::call('make:provider RepositoryServiceProvider');
        }

        $providerContent = File::get($providerPath);

        if (!str_contains($providerContent, "{$name}RepositoryInterface")) {
            $binding = <<<PHP

        \$this->app->bind(
            \\App\\Repositories\\Contracts\\{$name}RepositoryInterface::class,
            \\App\\Repositories\\Eloquent{$name}Repository::class
        );
PHP;

            $providerContent = str_replace(
                "public function register(): void\n    {\n        //",
                "public function register(): void\n    {{$binding}\n        //",
                $providerContent
            );

            File::put($providerPath, $providerContent);
        }
    }
}
