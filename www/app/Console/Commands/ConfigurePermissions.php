<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConfigurePermissions extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configure:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna permisos a storage y bootstrap/cache';

    /**
     * Execute the console command.
     */
    public function handle() {

        $this->applyRecursivePermissions(storage_path());
        $this->applyRecursivePermissions(base_path('bootstrap/cache'));

        $this->info('Permisos aplicados correctamente');
        $this->line('');
    }

    /**
     * Aplica permisos 775 y chown recursivo a un directorio
     */
    private function applyRecursivePermissions(string $path): void {

        if (!file_exists($path)) {
            $this->warn("No se encontro el path: $path");
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            @chmod($item->getPathname(), 0775);
            @chown($item->getPathname(), 'www-data');
        }

        // raiz
        @chmod($path, 0775);
        @chown($path, 'www-data');
    }
}
