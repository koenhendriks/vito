<?php

use App\Jobs\Installation\InstallMariadb;
use App\Jobs\Installation\InstallMysql;
use App\Jobs\Installation\InstallNginx;
use App\Jobs\Installation\InstallPHP;
use App\Jobs\Installation\InstallPHPMyAdmin;
use App\Jobs\Installation\InstallRedis;
use App\Jobs\Installation\InstallSupervisor;
use App\Jobs\Installation\InstallUfw;
use App\Jobs\Installation\UninstallPHP;
use App\Jobs\Installation\UninstallPHPMyAdmin;
use App\NotificationChannels\Discord;
use App\NotificationChannels\Email;
use App\NotificationChannels\Slack;
use App\ServerProviders\AWS;
use App\ServerProviders\DigitalOcean;
use App\ServerProviders\Hetzner;
use App\ServerProviders\Linode;
use App\ServerProviders\Vultr;
use App\ServiceHandlers\Database\Mysql;
use App\ServiceHandlers\Firewall\Ufw;
use App\ServiceHandlers\PHP;
use App\ServiceHandlers\ProcessManager\Supervisor;
use App\ServiceHandlers\Webserver\Nginx;
use App\SiteTypes\Laravel;
use App\SiteTypes\PHPSite;
use App\SourceControlProviders\Bitbucket;
use App\SourceControlProviders\Custom;
use App\SourceControlProviders\Github;
use App\SourceControlProviders\Gitlab;
use App\StorageProviders\Dropbox;

return [
    /*
     * SSH
     */
    'ssh_user' => env('SSH_USER', 'vito'),
    'ssh_public_key_name' => env('SSH_PUBLIC_KEY_NAME', 'ssh-public.key'),
    'ssh_private_key_name' => env('SSH_PRIVATE_KEY_NAME', 'ssh-private.pem'),
    'logs_disk' => env('SERVER_LOGS_DISK', 'server-logs-local'),
    'key_pairs_disk' => env('KEY_PAIRS_DISK', 'key-pairs-local'),

    /*
     * General
     */
    'operating_systems' => [
        // 'ubuntu_18',
        'ubuntu_20',
        'ubuntu_22',
    ],
    'webservers' => ['none', 'nginx'],
    'php_versions' => [
        'none',
        // '5.6',
        '7.0',
        '7.1',
        '7.2',
        '7.3',
        '7.4',
        '8.0',
        '8.1',
        '8.2',
    ],
    'databases' => ['none', 'mysql57', 'mysql80', 'mariadb'],
    'databases_name' => [
        'mysql57' => 'mysql',
        'mysql80' => 'mysql',
        'mariadb' => 'mariadb',
    ],
    'databases_version' => [
        'mysql57' => '5.7',
        'mysql80' => '8.0',
        'mariadb' => '10.3',
    ],

    /*
     * Server
     */
    'server_types' => \App\Enums\ServerType::getValues(),
    'server_types_class' => [
        \App\Enums\ServerType::REGULAR => \App\ServerTypes\Regular::class,
        \App\Enums\ServerType::DATABASE => \App\ServerTypes\Database::class,
    ],
    'server_providers' => \App\Enums\ServerProvider::getValues(),
    'server_providers_class' => [
        \App\Enums\ServerProvider::CUSTOM => \App\ServerProviders\Custom::class,
        \App\Enums\ServerProvider::AWS => AWS::class,
        \App\Enums\ServerProvider::LINODE => Linode::class,
        \App\Enums\ServerProvider::DIGITALOCEAN => DigitalOcean::class,
        \App\Enums\ServerProvider::VULTR => Vultr::class,
        \App\Enums\ServerProvider::HETZNER => Hetzner::class,
    ],
    'server_providers_default_user' => [
        'custom' => [
            'ubuntu_18' => 'root',
            'ubuntu_20' => 'root',
            'ubuntu_22' => 'root',
        ],
        'aws' => [
            'ubuntu_18' => 'ubuntu',
            'ubuntu_20' => 'ubuntu',
            'ubuntu_22' => 'ubuntu',
        ],
        'linode' => [
            'ubuntu_18' => 'root',
            'ubuntu_20' => 'root',
            'ubuntu_22' => 'root',
        ],
        'digitalocean' => [
            'ubuntu_18' => 'root',
            'ubuntu_20' => 'root',
            'ubuntu_22' => 'root',
        ],
        'vultr' => [
            'ubuntu_18' => 'root',
            'ubuntu_20' => 'root',
            'ubuntu_22' => 'root',
        ],
        'hetzner' => [
            'ubuntu_18' => 'root',
            'ubuntu_20' => 'root',
            'ubuntu_22' => 'root',
        ],
    ],

    /*
     * Service
     */
    'service_installers' => [
        'nginx' => InstallNginx::class,
        'mysql' => InstallMysql::class,
        'mariadb' => InstallMariadb::class,
        'php' => InstallPHP::class,
        'redis' => InstallRedis::class,
        'supervisor' => InstallSupervisor::class,
        'ufw' => InstallUfw::class,
        'phpmyadmin' => InstallPHPMyAdmin::class,
    ],
    'service_uninstallers' => [
        'phpmyadmin' => UninstallPHPMyAdmin::class,
        'php' => UninstallPHP::class,
    ],
    'service_handlers' => [
        'nginx' => Nginx::class,
        'mysql' => Mysql::class,
        'mariadb' => Mysql::class,
        'php' => PHP::class,
        'ufw' => Ufw::class,
        'supervisor' => Supervisor::class,
    ],
    'service_units' => [
        'nginx' => [
            'ubuntu_18' => [
                'latest' => 'nginx',
            ],
            'ubuntu_20' => [
                'latest' => 'nginx',
            ],
            'ubuntu_22' => [
                'latest' => 'nginx',
            ],
        ],
        'mysql' => [
            'ubuntu_18' => [
                '5.7' => 'mysql',
                '8.0' => 'mysql',
            ],
            'ubuntu_20' => [
                '5.7' => 'mysql',
                '8.0' => 'mysql',
            ],
            'ubuntu_22' => [
                '5.7' => 'mysql',
                '8.0' => 'mysql',
            ],
        ],
        'mariadb' => [
            'ubuntu_18' => [
                '10.3' => 'mariadb',
            ],
            'ubuntu_20' => [
                '10.3' => 'mariadb',
            ],
            'ubuntu_22' => [
                '10.3' => 'mariadb',
            ],
        ],
        'php' => [
            'ubuntu_18' => [
                '5.6' => 'php5.6-fpm',
                '7.0' => 'php7.0-fpm',
                '7.1' => 'php7.1-fpm',
                '7.2' => 'php7.2-fpm',
                '7.3' => 'php7.3-fpm',
                '7.4' => 'php7.4-fpm',
                '8.0' => 'php8.0-fpm',
                '8.1' => 'php8.1-fpm',
                '8.2' => 'php8.2-fpm',
            ],
            'ubuntu_20' => [
                '5.6' => 'php5.6-fpm',
                '7.0' => 'php7.0-fpm',
                '7.1' => 'php7.1-fpm',
                '7.2' => 'php7.2-fpm',
                '7.3' => 'php7.3-fpm',
                '7.4' => 'php7.4-fpm',
                '8.0' => 'php8.0-fpm',
                '8.1' => 'php8.1-fpm',
                '8.2' => 'php8.2-fpm',
            ],
            'ubuntu_22' => [
                '5.6' => 'php5.6-fpm',
                '7.0' => 'php7.0-fpm',
                '7.1' => 'php7.1-fpm',
                '7.2' => 'php7.2-fpm',
                '7.3' => 'php7.3-fpm',
                '7.4' => 'php7.4-fpm',
                '8.0' => 'php8.0-fpm',
                '8.1' => 'php8.1-fpm',
                '8.2' => 'php8.2-fpm',
            ],
        ],
        'redis' => [
            'ubuntu_18' => [
                'latest' => 'redis',
            ],
            'ubuntu_20' => [
                'latest' => 'redis',
            ],
            'ubuntu_22' => [
                'latest' => 'redis',
            ],
        ],
        'supervisor' => [
            'ubuntu_18' => [
                'latest' => 'supervisor',
            ],
            'ubuntu_20' => [
                'latest' => 'supervisor',
            ],
            'ubuntu_22' => [
                'latest' => 'supervisor',
            ],
        ],
        'ufw' => [
            'ubuntu_18' => [
                'latest' => 'ufw',
            ],
            'ubuntu_20' => [
                'latest' => 'ufw',
            ],
            'ubuntu_22' => [
                'latest' => 'ufw',
            ],
        ],
    ],

    /*
     * Site
     */
    'site_types' => [
        \App\Enums\SiteType::PHP,
        \App\Enums\SiteType::LARAVEL,
        // \App\Enums\SiteType::WORDPRESS,
    ],
    'site_types_class' => [
        \App\Enums\SiteType::PHP => PHPSite::class,
        \App\Enums\SiteType::LARAVEL => Laravel::class,
        // \App\Enums\SiteType::WORDPRESS => Wordpress::class,
    ],

    /*
     * Source Control
     */
    'source_control_providers' => [
        'github',
        'gitlab',
        'bitbucket',
        'custom',
    ],
    'source_control_providers_class' => [
        'github' => Github::class,
        'gitlab' => Gitlab::class,
        'bitbucket' => Bitbucket::class,
        'custom' => Custom::class,
    ],

    /*
     * available php extensions
     */
    'php_extensions' => [
        'imagick',
        'geoip',
        'exif',
        'gmagick',
        'gmp',
        'intl',
    ],

    /*
     * php settings
     */
    'php_settings' => [
        'upload_max_filesize' => '2',
        'memory_limit' => '128',
        'max_execution_time' => '30',
        'post_max_size' => '2',
    ],
    'php_settings_unit' => [
        'upload_max_filesize' => 'M',
        'memory_limit' => 'M',
        'max_execution_time' => 'S',
        'post_max_size' => 'M',
    ],

    /*
     * firewall
     */
    'firewall_protocols_port' => [
        'ssh' => 22,
        'http' => 80,
        'https' => 443,
        'mysql' => 3306,
        'ftp' => 21,
        'phpmyadmin' => 54331,
        'tcp' => '',
        'udp' => '',
    ],

    /*
     * Disable these IPs for servers
     */
    'restricted_ip_addresses' => array_merge(
        ['127.0.0.1', 'localhost', '0.0.0.0'],
        explode(',', env('RESTRICTED_IP_ADDRESSES', ''))
    ),

    /*
     * Notification channels
     */
    'notification_channels_providers' => [
        \App\Enums\NotificationChannel::SLACK,
        \App\Enums\NotificationChannel::DISCORD,
        \App\Enums\NotificationChannel::EMAIL,
    ],
    'notification_channels_providers_class' => [
        \App\Enums\NotificationChannel::SLACK => Slack::class,
        \App\Enums\NotificationChannel::DISCORD => Discord::class,
        \App\Enums\NotificationChannel::EMAIL => Email::class,
    ],

    /*
     * storage providers
     */
    'storage_providers' => [
        'dropbox',
    ],
    'storage_providers_class' => [
        'dropbox' => Dropbox::class,
    ],
];
