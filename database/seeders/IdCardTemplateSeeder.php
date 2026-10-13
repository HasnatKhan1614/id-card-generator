<?php

namespace Database\Seeders;

use App\Models\IdCardTemplate;
use Illuminate\Database\Seeder;

class IdCardTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Classic Blue',
                'is_default' => true,
                'is_active' => true,
                'settings' => array_merge(IdCardTemplate::defaults(), [
                    'layout' => 'classic',
                    'header_bg' => '#007bff',
                    'accent_color' => '#0056b3',
                ]),
            ],
            [
                'name' => 'Dark Minimal',
                'is_default' => false,
                'is_active' => true,
                'settings' => array_merge(IdCardTemplate::defaults(), [
                    'layout' => 'classic',
                    'header_bg' => '#212529',
                    'footer_bg' => '#212529',
                    'footer_text' => '#adb5bd',
                    'accent_color' => '#212529',
                    'border_color' => '#adb5bd',
                ]),
            ],
            [
                'name' => 'Stacked Compact',
                'is_default' => false,
                'is_active' => true,
                'settings' => array_merge(IdCardTemplate::defaults(), [
                    'layout' => 'stacked',
                    'header_bg' => '#28a745',
                    'accent_color' => '#1e7e34',
                    'photo_size' => 'small',
                    'show_address' => false,
                ]),
            ],
            [
                'name' => 'Banner Accent',
                'is_default' => false,
                'is_active' => true,
                'settings' => array_merge(IdCardTemplate::defaults(), [
                    'layout' => 'banner',
                    'header_bg' => '#6f42c1',
                    'accent_color' => '#5a32a3',
                    'footer_bg' => '#f3eef9',
                    'show_campus' => true,
                    'show_phone' => false,
                ]),
            ],
        ];

        foreach ($templates as $template) {
            IdCardTemplate::firstOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }
}
