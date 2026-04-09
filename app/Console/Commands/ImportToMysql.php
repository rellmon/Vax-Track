<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class ImportToMysql extends Command
{
    protected $signature = 'import:mysql';
    protected $description = 'Import SQLite data to MySQL';

    public function handle()
    {
        // SQLite connection (local)
        $sqlite = DB::connection('sqlite');
        
        // Railway MySQL connection (create directly)
        $mysqlPdo = new PDO(
            'mysql:host=mainline.proxy.rlwy.net;port=18379;dbname=railway;charset=utf8mb4',
            'root',
            'FTPaHICViXirNrIoVCfJcVTsioFKCzTP',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Disable foreign key checks
        $mysqlPdo->exec('SET FOREIGN_KEY_CHECKS=0');

        $tables = $sqlite->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT IN ('migrations', 'sqlite_sequence')");

        foreach ($tables as $table) {
            $tableName = $table->name;
            $rows = $sqlite->table($tableName)->get();

            if ($rows->isEmpty()) {
                $this->info("Skipping {$tableName} (empty)");
                continue;
            }

            $this->info("Importing {$tableName}...");

            // Truncate MySQL table
            $mysqlPdo->exec("TRUNCATE TABLE `{$tableName}`");

            // Get columns from first row
            $firstRow = $rows[0];
            $sourceColumns = array_keys((array) $firstRow);
            
            // Get MySQL table schema to filter columns that exist in database
            $columnsQuery = $mysqlPdo->query("DESCRIBE `{$tableName}`");
            $mysqlColumns = $columnsQuery->fetchAll(PDO::FETCH_COLUMN, 0);
            
            // Only use columns that exist in both source and target
            $columns = array_intersect($sourceColumns, $mysqlColumns);
            $columnStr = '`' . implode('`,`', $columns) . '`';
            $placeholders = implode(',', array_fill(0, count($columns), '?'));
            
            $sql = "INSERT INTO `{$tableName}` ({$columnStr}) VALUES ({$placeholders})";
            $stmt = $mysqlPdo->prepare($sql);

            foreach ($rows as $row) {
                $rowObj = (array) $row;
                // Only extract values for columns that are being inserted
                $values = array_values(array_intersect_key($rowObj, array_flip($columns)));
                $stmt->execute($values);
            }

            $this->info("Done: {$tableName}");
        }

        // Re-enable foreign key checks
        $mysqlPdo->exec('SET FOREIGN_KEY_CHECKS=1');

        $this->info('All data imported successfully!');
    }
}