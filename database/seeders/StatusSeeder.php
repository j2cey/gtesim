<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => "active", 'code' => "active", 'style' => "success", 'is_default' => 1],
            ['name' => "inactive", 'code' => "inactive", 'style' => "danger", 'is_default' => 0]
        ];
        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
