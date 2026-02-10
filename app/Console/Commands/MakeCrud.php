<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeCrud extends Command
{
    protected $signature = 'make:crud
        {name}
        {--force}
        {--only=}
        {--module=}
        {--api}
        {--web}';

    protected $description = 'Generate full CRUD (Controller, Service, Repository, Interface, Views, Routes)';

    /* ====================== HANDLE ====================== */

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $only = $this->option('only')
            ? explode(',', $this->option('only'))
            : ['controller','service','repository','interface','views','routes', 'request'];

        $this->createDirectories();

        if (in_array('controller', $only)) $this->createController($name);
        if (in_array('service', $only)) $this->createService($name);
        if (in_array('repository', $only)) $this->createRepository($name);
        if (in_array('interface', $only)) $this->createInterface($name);
        if (in_array('views', $only)) $this->createViews($name);
        if (in_array('routes', $only)) $this->createRoutes($name);
        if (in_array('request', $only)) $this->createRequest($name);

        $this->bindRepository($name);

        $this->info("✅ CRUD {$name} generated successfully");
    }

    /* ====================== HELPERS ====================== */

    private function module(): string
    {
        return $this->option('module')
            ? ucfirst($this->option('module'))
            : 'Web';
    }

    private function viewModule(): string
    {
        return strtolower($this->option('module') ?? 'web');
    }

    private function shouldCreate(string $path, string $label): bool
    {
        if (File::exists($path) && !$this->option('force')) {
            $this->warn("⏭ {$label} exists, skipped");
            return false;
        }
        return true;
    }

    private function renderStub(string $stub, array $data): string
        {
            $path = base_path("stubs/{$stub}");

            if (!File::exists($path)) {
                $this->error("Stub missing: {$stub}");
                exit(1);
            }

            $content = File::get($path);

            foreach ($data as $key => $value) {
                $content = str_replace('{{ '.$key.' }}', $value, $content);
            }

            return $content;
        }


    private function createDirectories()
    {
        foreach ([
            app_path('Services'),
            app_path('Repositories'),
            app_path('Repositories/Contracts'),
            app_path("Http/Controllers/{$this->module()}"),
            app_path("Http/Requests"),
        ] as $dir) {
            File::ensureDirectoryExists($dir);
        }
    }

    /* ====================== CONTROLLER ====================== */

    private function createController($name)
    {
        $varName = lcfirst($name);
        $type = $this->option('api') ? 'api' : 'web';
        $path = app_path("Http/Controllers/{$this->module()}/{$name}Controller.php");

        if (!$this->shouldCreate($path, "Controller")) return;

        File::put($path, $this->renderStub(
            "controller.{$type}.stub",
            [
                'name' => $name,
                'module' => $this->module(),
                'service' => "{$name}Service",
                'view_path' => "{$this->viewModule()}.".strtolower($name),
                'route' => strtolower($name),
                'varName' => $varName
            ]
        ));

        $this->info("✔ Controller created");
    }

    /* ====================== REQUEST ====================== */
    private function createRequest($name)
    {
        $varName = lcfirst($name);
        $path = app_path("Http/Requests/{$name}Request.php");

        if (!$this->shouldCreate($path, "Request")) return;

        File::put($path, $this->renderStub(
            'request.stub',
            [
                'name' => $name,
                'varName' => $varName,
            ]
        ));

        $this->info("✔ Request created");
    }


    /* ====================== SERVICE ====================== */

    private function createService($name)
    {
        $varName = lcfirst($name);
        $path = app_path("Services/{$name}Service.php");

        if (!$this->shouldCreate($path, "Service")) return;

        File::put($path, $this->renderStub(
            'service.stub',
            [
                'name' => $name,
                'varName' => $varName
            ]
        ));

        $this->info("✔ Service created");
    }

    /* ====================== REPOSITORY ====================== */

    private function createRepository($name)
    {
        $varName = lcfirst($name);
        $path = app_path("Repositories/Eloquent{$name}Repository.php");

        if (!$this->shouldCreate($path, "Repository")) return;

        File::put($path, $this->renderStub(
            'repository.stub',
            [
                'name' => $name,
                'varName' => $varName
            ]
        ));

        $this->info("✔ Repository created");
    }

    /* ====================== INTERFACE ====================== */

    private function createInterface($name)
    {
        $varName = lcfirst($name);
        $path = app_path("Repositories/Contracts/{$name}RepositoryInterface.php");

        if (!$this->shouldCreate($path, "Interface")) return;

        File::put($path, $this->renderStub(
            'interface.stub',
            [
                'name' => $name,
                'varName' => $varName
            ]
        ));

        $this->info("✔ Interface created");
    }

    /* ====================== VIEWS ====================== */

    private function createViews($name)
    {
        if ($this->option('api')) return;

        $varName = lcfirst($name);
        $basePath = resource_path("views/{$this->viewModule()}/".strtolower($name));
        File::ensureDirectoryExists($basePath);

        foreach (['index','create','edit','show'] as $view) {
            $path = "{$basePath}/{$view}.blade.php";

            if (!$this->shouldCreate($path, "View {$view}")) continue;

            File::put($path, $this->renderStub(
                "views/{$view}.stub",
                [
                    'name' => $name,
                    'route' => strtolower($name),
                    'varName' => $varName,
                ]
            ));
        }

        $this->info("✔ Views created");
    }

    /* ====================== ROUTES ====================== */

    private function createRoutes($name)
    {
        $routeFile = $this->option('api')
            ? base_path('routes/api.php')
            : base_path('routes/web.php');

        $routes = File::get($routeFile);

        if (str_contains($routes, "{$name}Controller")) {
            $this->warn("⏭ Routes already exist");
            return;
        }

        $stub = $this->option('api') ? 'routes.api.stub' : 'routes.web.stub';

        File::append($routeFile, "\n".$this->renderStub(
            $stub,
            [
                'route' => strtolower($name),
                'name' => $name,
                'module' => $this->module(),
            ]
        ));

        $this->info("✔ Routes added");
    }

    /* ====================== BINDING ====================== */

    private function bindRepository($name)
    {
        $provider = app_path('Providers/RepositoryServiceProvider.php');

        if (!File::exists($provider)) {
            Artisan::call('make:provider RepositoryServiceProvider');
        }

        $content = File::get($provider);

        if (str_contains($content, "{$name}RepositoryInterface")) return;

        $binding = <<<PHP

        \$this->app->bind(
            \\App\\Repositories\\Contracts\\{$name}RepositoryInterface::class,
            \\App\\Repositories\\Eloquent{$name}Repository::class
        );
PHP;

        $content = str_replace(
            "public function register(): void\n    {",
            "public function register(): void\n    {{$binding}",
            $content
        );

        File::put($provider, $content);
        $this->info("✔ Repository binding added");
    }
}
