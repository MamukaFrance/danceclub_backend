<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    protected $signature = 'make:crud
        {name}
        {--force}
        {--only=}
        {--module=}
        {--api}
        {--web}';

    protected $description = 'Generate full CRUD ( Model, Controller, Request, Exception, Service, Repository, Interface, Views, Routes)';

    /* ====================== HANDLE ====================== */

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $only = $this->option('only')
            ? explode(',', $this->option('only'))
            : ['model','controller','request', 'policy','exception','service','repository','interface','views','routes'];

        $this->createDirectories();

        if (in_array('model', $only)) $this->createModel($name);
        if (in_array('controller', $only)) $this->createController($name);
        if (in_array('request', $only)) $this->createRequest($name);
        if (in_array('policy', $only)) $this->createPolicy($name);
        if (in_array('exception', $only)) $this->createException($name);
        if (in_array('service', $only)) $this->createService($name);
        if (in_array('repository', $only)) $this->createRepository($name);
        if (in_array('interface', $only)) $this->createInterface($name);
        if (in_array('views', $only)) $this->createViews($name);
        if (in_array('routes', $only)) $this->createRoutes($name);
        
        $this->bindRepository($name);
        // $this->bindException($name);

        $this->info("✅ CRUD {$name} generated successfully");
    }

    /* ====================== HELPERS ====================== */

    private function module(): string
    {
        return $this->option('module')
            ? ucfirst($this->option('module'))
            : 'web';
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
                throw new \RuntimeException("Stub missing: {$stub}");
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
            app_path("Exceptions"),
            app_path("Policies"),
        ] as $dir) {
            File::ensureDirectoryExists($dir);
        }
    }

    /* ====================== MODEL ====================== */
    private function createModel(string $name)
    {
        $path = app_path("Models/{$name}.php");

        if (!$this->shouldCreate($path, "Model")) return;

        Artisan::call('make:model', [
            'name' => $name,
            '--migration' => true,
            '--factory' => true,
        ]);

        $this->info("✔ Model created");
    }


    /* ====================== CONTROLLER ====================== */

    private function createController($name)
    {
        $model = $name;
        $modelVar = lcfirst($name);
        $table = Str::snake(Str::plural($name));
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

    private function createRequest(string $name)
    {
        $path = app_path("Http/Requests/{$name}Request.php");

        if (!$this->shouldCreate($path, "Request")) return;

        $modelClass = "App\\Models\\{$name}";

        // Vérifie que le Model existe
        if (!class_exists($modelClass)) {
            $this->error("❌ Model {$name} does not exist. Create it first.");
            return;
        }

        $model = new $modelClass;

        // Génère les règles automatiquement depuis $fillable
        $rules = [];
        foreach ($model->getFillable() as $field) {
            // Tu peux personnaliser le type si tu veux
            $rules[$field] = 'required';
        }

        // Génère le contenu du stub avec les règles
        $stubContent = $this->renderStub('request.stub', [
            'name' => $name,
            'varName' => lcfirst($name),
            'rules' => $this->formatRules($rules),
        ]);

        File::put($path, $stubContent);

        $this->info("✔ Request created");
    }

    /**
     * Formate les règles pour le stub
     */
    private function formatRules(array $rules): string
    {
        $lines = [];
        foreach ($rules as $field => $rule) {
            $lines[] = "        '{$field}' => '{$rule}',";
        }
        return "[\n" . implode("\n", $lines) . "\n        ]";
    }

    /* ====================== POLICY ====================== */

    private function createPolicy($name)
    {
        $varName = lcfirst($name);
        $path = app_path("Policies/{$name}Policy.php");

        if (!$this->shouldCreate($path, "Policy")) return;

        File::put($path, $this->renderStub(
            'policy.stub',
            [
                'name' => $name,
                'varName' => $varName,
            ]
        ));

        $this->info("✔ Policy created");
    }

    /* ====================== Exception ====================== */


    private function createException($name)
    {
        $path = app_path("Exceptions/{$name}Exception.php");

        if (!$this->shouldCreate($path, "Exception")) return;

        File::put($path, $this->renderStub(
            'exception.stub',
            [
                'name' => $name,
            ]
        ));

        $this->info("✔ Exception created");
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
                    'form_fields' => $this->generateInputs($name),
                    'index_fields' => $this->generateIndexFields($name),
                ]
            ));
            $this->info("✔ view $view created");
        }
        
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

        if (str_contains($content, "{$name}RepositoryInterface")){
            $this->warn("⏭ Repository binding already exist");
            return;
        } 

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

    private function bindException($name)
    {
        $exception = app_path('Exceptions/Handler.php');

        if (!File::exists($exception)) {
            Artisan::call('make:exception Handler');
        }

        $content = File::get($exception);

        if (str_contains($content, "{$name}Exception")){
            $this->warn("⏭ Exception binding already exist");
            return;
        } 

        $binding = <<<PHP

        \$this->renderable(function ({$name}Exception \$e, \$request) {
            return back()
                ->withInput()
                ->with('error', \$e->getMessage());
        });
        
PHP;    

        $content = str_replace(
            "public function register(): void\n    {",
            "public function register(): void\n    {{$binding}",
            $content
        );

        File::put($exception, $content);
        $this->info("✔ Exception binding added");
    }

    /* ====================== INPUT ====================== */
    private function generateInputs(string $name): string
    {
        $model = "App\\Models\\{$name}";
        if (!class_exists($model)) return '';

        $fields = (new $model)->getFillable();
        $var = lcfirst($name);

        $html = [];

        foreach ($fields as $field) {

            if (in_array($field, ['id', 'created_at', 'updated_at'])) {
                continue;
            }

            $label = ucfirst(str_replace('_', ' ', $field));

            // textarea
            if (str_contains($field, 'description') || str_contains($field, 'content')) {
                $html[] = <<<BLADE
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700">{$label}</label>

        <textarea
            name="{$field}"
            class="w-full px-4 py-2 border rounded-md"
        >{{ old('{$field}', \${$var}->{$field} ?? '') }}</textarea>

        @error('{$field}')
            <p class="mt-1 text-sm text-red-500">{{ \$message }}</p>
        @enderror
    </div>
    BLADE;
                continue;
            }

            // select for foreign key
            if (str_ends_with($field, '_id')) {
                $html[] = <<<BLADE
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700">{$label}</label>

        <select name="{$field}" class="w-full px-4 py-2 border rounded-md">
            {{-- options --}}
        </select>

        @error('{$field}')
            <p class="mt-1 text-sm text-red-500">{{ \$message }}</p>
        @enderror
    </div>
    BLADE;
                continue;
            }

            $type = match (true) {
                str_contains($field, 'date') => 'date',
                str_contains($field, 'price'),
                str_contains($field, 'capacity') => 'number',
                default => 'text',
            };

            $html[] = <<<BLADE
    <div class="mb-4">
        <label for="{$field}" class="block mb-1 font-semibold text-gray-700">
            {$label}
        </label>

        <input
            type="{$type}"
            id="{$field}"
            name="{$field}"
            value="{{ old('{$field}', \${$var}->{$field} ?? '') }}"
            class="w-full px-4 py-2 border rounded-md @error('{$field}') border-red-500 @enderror"
        >

        @error('{$field}')
            <p class="mt-1 text-sm text-red-500">{{ \$message }}</p>
        @enderror
    </div>
    BLADE;
        }

        return implode("\n", $html);
    }



    /* ====================== INDEX ====================== */

    private function generateIndexFields(string $name): string
{
    $model = "App\\Models\\{$name}";
    if (!class_exists($model)) return '';

    $fields = (new $model)->getFillable();
    $var = lcfirst($name);

    $html = [];

    foreach ($fields as $field) {

        if (in_array($field, ['id', 'created_at', 'updated_at'])) {
            continue;
        }

        $label = ucfirst(str_replace('_', ' ', $field));

        // Foreign key
        if (str_ends_with($field, '_id')) {

            $relation = str_replace('_id', '', $field);

            $html[] = <<<BLADE
        <p class="text-sm text-gray-600">
            <span class="font-medium">{$label} :</span>
            {{ \${$var}->{$relation}->name ?? '-' }}
        </p>
BLADE;
            continue;
        }

        // Date formatting
        if (str_contains($field, 'date')) {
            $html[] = <<<BLADE
        <p class="text-sm text-gray-600">
            <span class="font-medium">{$label} :</span>
            {{ \${$var}->{$field}?->format('d/m/Y') }}
        </p>
BLADE;
            continue;
        }

        // Default display
        $html[] = <<<BLADE
        <p class="text-sm text-gray-600">
            <span class="font-medium">{$label} :</span>
            {{ \${$var}->{$field} }}
        </p>
BLADE;
    }

    return implode("\n", $html);
}

}
