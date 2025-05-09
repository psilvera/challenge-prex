<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

class SetPassportSecret extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala Passport, crea un cliente y guarda los datos en el archivo .env';

    /**
     * Execute the console command.
     */
    public function handle() {

        $this->info('Instalando Passport ...');

        $this->call('passport:keys', ['--force' => true]);

        $client = Client::create([
            'name' => 'Prex Challenge Client',
            'redirect' => config('app.url'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'secret' => Str::random(40),
        ]);

        $this->updateEnv('PASSPORT_CLIENT_ID', $client->id);
        $this->updateEnv('PASSPORT_CLIENT_SECRET', $client->secret);

        // seteo usuario y permisos para evitar errores silenciosos
        @chown(storage_path('oauth-private.key'), 'www-data');
        @chown(storage_path('oauth-public.key'), 'www-data');
        @chmod(storage_path('oauth-private.key'), 0640);
        @chmod(storage_path('oauth-public.key'), 0640);

        $this->call(command: 'optimize:clear');

        $this->info('Passport Client creado OK');
        $this->line("Client ID: <info>{$client->id}</info>");
        $this->line("Client Secret: <info>{$client->secret}</info>");
        $this->line('');
    }

    /**
     * Busca y reemplaza dentro del env, agrega lo nuevo
     * al final del archivo
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected function updateEnv($key, $value) {

        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return $this->error("Verificá que se haya creado bien el archivo .env");
        }

        $content = File::get($envPath);

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content .= "\n{$key}={$value}";
        }

        File::put($envPath, $content);
    }
}
