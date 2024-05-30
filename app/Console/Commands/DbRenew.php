<?php

namespace App\Console\Commands;

use App\Traits\WzCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class DbRenew extends Command
{
    use WzCommand;

    protected $signature = 'db:renew 
        {--file=default : Filename for database default in sql format}
        {--path= : Path file .sql default exists}
        {--force : Force the operation to run when in production}
    ';

    protected $description = 'Renew the database and start migration from the first time';

    public function handle()
    {
        $this->verifyUsingMysql();

        $filename = rtrim($this->option('file'), '.sql');
        $path = $this->option('path') ?? '';

        // Validate availability
        if ($path != '') {
            $path = rtrim($path, '/') . '/';
        }
        $dbFile = database_path("{$path}{$filename}.sql");

        $confirmed = true;
        if (!$this->option('force')) {
            $confirmed = $this->confirm('Are you sure you want to renew the database? This will delete all existing data.');
        } else {
            $this->ln();
        }

        if ($confirmed || $this->option('force')) {
            if ($this->databaseExists()) {
                // Validate availability
                $this->fileExists($dbFile, true);

                $this->dropAllTables();
                $importedDirectory = database_path('sql/imported');

                if (File::exists($importedDirectory)) {
                    File::deleteDirectory($importedDirectory);
                    $this->inform('Imported .sql files directory removed successfully.');
                }
            } else {
                // Proses creating database masih error jadi untuk saat ini tidak ditambahkan dulu
                $this->danger('Database not found');
                return;

                if (!$this->option('force') && !$this->confirm('Database not found. Do you want to create it?')) {
                    $this->warn('Operation cancelled. Database not created.');
                    $this->end();
                }

                // Ini masih error
                $this->createDatabase();
            }
        } else {
            $this->warn('Operation cancelled.');
            $this->end();
        }

        $this->inform("Importing $filename.sql...");
        $this->importSqlFile($dbFile, time());
        $this->ln();
        $this->success('Database renewed successfully.', false);

        $this->end();
    }

    protected function databaseExists()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function dropAllTables()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = reset($table);
            DB::statement('DROP TABLE ' . $tableName);
            $this->inform("$tableName table dropped");
        }

        $this->ln();
    }

    // This still error
    protected function createDatabase()
    {
        try {
            $this->inform('Creating database...');
            DB::connection()->getPdo()->exec('CREATE DATABASE IF NOT EXISTS ' . env('DB_DATABASE'));
        } catch (\Exception $e) {
            $this->error('Failed to create database: ' . $e->getMessage());
            exit(1);
        }
    }
}
