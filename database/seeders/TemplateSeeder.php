<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('templates') as $key => $template) {
            Template::updateOrCreate([
                'id' => key($template),
                'name' => $key,
                'template' => value($template[key($template)]),
                'user_id' => 0,
            ]);
        }
    }
}
