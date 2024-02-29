<?php

    /*
        --------------------------------
        Application configuration
        --------------------------------
        In this file you can define your global application configuration.
        Some settings are retrieved from the environment config file. Be sure to rename ".env.example" to ".env" first.

        -----------------------------------------------------------------------------------------
        WARNING: Sensitive data should never be stored here! Use the environment config instead.
        -----------------------------------------------------------------------------------------
    */

    return [

        // Current environment name
        'env' => Env::get('APP_ENV', 'development'),

        // Application maintenance mode
        'maintenance' => [

            // Enable maintenance mode
            'enabled' => filter_var(
                            Env::get('APP_MAINTENANCE', false),
                        FILTER_VALIDATE_BOOLEAN),

            // Maintenance mode bypass key
            'bypass_key' => Env::get('MAINTENANCE_KEY')

        ],

        // Skeltch templating engine
        'skeltch' => [

            // Enable Skeltch compiler
            'enabled' => true,

            // Enable views caching
            'cache' => true,

            // Cache files location
            'path' => Util::location('storage/cache')

        ],

        // Application error reporting
        'error_reporting' => [

            // Error reporting level
            'level' => filter_var(
                            Env::get('APP_DEBUG', true),
                        FILTER_VALIDATE_BOOLEAN) ? E_ALL : 0,

            // Enable error logging
            'logging' => true,

            // Error log file location
            'file' => Util::location('storage/error.log')

        ],

        // Application session management
        'session' => [

            // Session cookie name
            'name' => 'app_session',

            // Unused session lifetime
            'lifetime' => 120,

            // Number of requests when to run the garbage collector
            'gc_cleaning' => 50,

            // Session files location
            'path' => Util::location('storage/session'),

            // Allow session usage only in secure connections (https)
            'secure' => false,

            // Restrict session access to the HTTP protocol only
            'restrict' => true

        ],

        // Application cookies management
        'cookies' => [

            // Allow cookies usage only through secure connections (https)
            'secure' => false,

            // Restrict cookies access to the HTTP protocol only
            'restrict' => true

        ],

        // Application secret keys
        'secret' => [

            // Key used in encrypting functions
            'app_key' => Env::get('APP_KEY'),

            // Token used in encrypting functions
            'app_token' => Env::get('APP_TOKEN')

        ],

        // Application database connection settings
        'database' => [

            // Default connection
            'default' => [
                'host' => Env::get('DB_HOST', 'localhost'),
                'username' => Env::get('DB_USERNAME', 'root'),
                'password' => Env::get('DB_PASSWORD', ''),
                'db' => Env::get('DB_DATABASE', 'glowie'),
                'port' => Env::get('DB_PORT', 3306),
                'charset' => 'utf8',
                'strict' => false
            ]

        ],

        // Authentication settings
        'auth' => [

            // Users model
            'model' => \Glowie\Models\Users::class,

            // User field name
            'user_field' => 'email',

            // Password field name
            'password_field' => 'password'

        ],

        // Migrations settings
        'migrations' => [

            // Migrations history table name
            'table' => 'migrations'

        ],

        // Cache settings
        'cache' => [

            // Cache file path
            'path' => Util::location('storage/cache/cache.tmp')

        ],

        // Cross-Origin Resource Sharing (CORS) settings
        'cors' => [

            // Enable CORS headers
            'enabled' => true,

            // List of allowed methods (use * for all)
            'allowed_methods' => ['*'],

            // List of allowed origins (use * for all)
            'allowed_origins' => ['*'],

            // List of allowed headers (use * for all)
            'allowed_headers' => ['*'],

            // List of exposed headers
            'exposed_headers' => [],

            // Preflight request cache time
            'max_age' => 0,

            // Allow credentials to be exposed
            'allow_credentials' => false

        ],

        // Application plugins
        'plugins' => [],

        // Firefly Sandbox settings
        'sandbox' => [

            // Sandbox class alias list
            'alias' => [
                'Factory' => \Glowie\Core\Database\Factory::class,
                'Kraken' => \Glowie\Core\Database\Kraken::class,
                'Model' => \Glowie\Core\Database\Model::class,
                'Skeleton' => \Glowie\Core\Database\Skeleton::class,
                'Rails' => \Glowie\Core\Http\Rails::class,
                'Cache' => \Glowie\Core\Tools\Cache::class,
                'Crawler' => \Glowie\Core\Tools\Crawler::class,
                'Mailer' => \Glowie\Core\Tools\Mailer::class,
                'Validator' => \Glowie\Core\Tools\Validator::class,
                'Collection' => \Glowie\Core\Collection::class,
                'Element' => \Glowie\Core\Element::class
            ]

        ],

        // Application miscellaneous settings
        'other' => [

            // Application URL (for CLI route mocking only)
            'url' => 'http://localhost',

            // Default language
            'language' => 'en',

            // Default timezone
            'timezone' => 'America/Sao_Paulo'

        ]

    ];

?>