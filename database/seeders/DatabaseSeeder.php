<?php

namespace Database\Seeders;

use App\Enums\ServiceStatus;
use App\Enums\SiteType;
use App\Models\Server;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);
        $server = Server::factory()->create([
            'user_id' => $user->id,
        ]);
        $server->services()->create([
            'type' => 'database',
            'name' => config('core.databases_name.mysql80'),
            'version' => config('core.databases_version.mysql80'),
            'status' => ServiceStatus::READY,
        ]);
        $server->services()->create([
            'type' => 'php',
            'type_data' => [
                'extensions' => [],
            ],
            'name' => 'php',
            'version' => '8.1',
            'status' => ServiceStatus::READY,
        ]);
        $server->services()->create([
            'type' => 'webserver',
            'name' => 'nginx',
            'version' => 'latest',
            'status' => ServiceStatus::READY,
        ]);
        Site::factory()->create([
            'server_id' => $server->id,
            'type' => SiteType::LARAVEL,
        ]);
    }
}
