<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sqlPath = base_path('database_dump.sql');
        
        if (File::exists($sqlPath)) {
            $this->command->info('Loading database_dump.sql into database...');
            
            // Disable foreign key constraints during import
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            $sql = File::get_contents($sqlPath);
            
            // Execute raw SQL script
            DB::unprepared($sql);
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->command->info('Database successfully restored from dump.');
        } else {
            $this->command->warn('database_dump.sql not found! Running default seeders.');
            $this->call([
                MeyhaneMenuSeeder::class,
                SettingSeeder::class,
                GallerySeeder::class,
            ]);
        }
    }
}
