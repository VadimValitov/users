<?php
declare(strict_types=1);

use Doctrine\DBAL\Driver\PDO\MySQL\Driver;
use Doctrine\Migrations\Configuration\Migration\ConfigurationLoader;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Roave\PsrContainerDoctrine\Migrations\CommandFactory;
use Roave\PsrContainerDoctrine\Migrations\ConfigurationLoaderFactory;
use Roave\PsrContainerDoctrine\Migrations\DependencyFactoryFactory;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => Driver::class,
                'params' => [
                    'host' => getenv('MYSQL_HOST'),
                    'port' => '3306',
                    'user' => getenv('MYSQL_USER'),
                    'password' => getenv('MYSQL_PASSWORD'),
                    'dbname' => getenv('MYSQL_DATABASE'),
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'types' => [
                ]
            ],
        ],
        'driver' => [
            'default_annotation_driver' => [
                'class' => AttributeDriver::class,
                'cache' => 'array',
                'paths' => [
                    dirname(__DIR__, 2) . '/src/Domain/Entity'
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'App\Domain\Entity' => 'default_annotation_driver',
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name' => 'DoctrineMigrationVersions',
                    'version_column_name' => 'version',
                    'version_column_length' => 1024,
                    'executed_at_column_name' => 'executedAt',
                    'execution_time_column_name' => 'executionTime',
                ],
                'migrations_paths' => [], // an array of namespace => path
                'migrations' => [], // an array of fully qualified migrations
                'all_or_nothing' => false,
                'check_database_platform' => true,
                'organize_migrations' => 'year', // year or year_and_month
                'custom_template' => null,
            ],
        ],
    ],
    'dependencies' => [
        'factories' => [
            ExecuteCommand::class => CommandFactory::class,
            ConfigurationLoader::class => ConfigurationLoaderFactory::class,
            DependencyFactory::class => DependencyFactoryFactory::class,
        ],
    ],
];
