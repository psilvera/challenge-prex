<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PrexInstall extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prex:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configura el Entorno';

    /**
     * Execute the console command.
     */
    public function handle() {

        $this->line('');

        $this->info('Ejecutando Migraciones...');
        Artisan::call('migrate');
        $this->line(Artisan::output());

        $this->info('Ejecutando Seeders...');
        Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        $this->line(Artisan::output());

        $this->info('Instalando Passport y seteando permisos...');
        $this->line('');
        $this->call('configure:permissions');
        $this->call('passport:secret');

        $this->info('Configuracion Completa');
        $this->line('');
    }
}
