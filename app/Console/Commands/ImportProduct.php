<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file_content = Storage::get('import/result.csv');
        $rows = explode(PHP_EOL, $file_content);
        foreach ($rows as $key => $row) {
            if (trim($row) !== '' && $key !== 0) {
                $item = str_getcsv($row);
                Product::create([
                    'name' => $item[0],
                    'proteins' => $item[1] != '' ? $item[1] : 0.0,
                    'fats' => $item[2] != '' ? $item[2] : 0.0,
                    'carbs' => $item[3] != '' ? $item[3] : 0.0,
                    'ccal' => $item[4] != '' ? $item[4] : 0.0,
                    'meas_value' => 0,
                    'chpu' => Str::slug($item[0])
                ]);
            }
        }
        return 0;
    }
}
