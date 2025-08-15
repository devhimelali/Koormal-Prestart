<?php

namespace Database\Seeders;

use App\Models\CrossCriteria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CrossCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crossCriterias = [
            [
                'name' => 'Sustainable Health and Safety Improvement',
                'color' => '#0000ff',
                'description' => '<p>All</p>',
                'bg_color' => 'rgba(0, 0, 255, 0.3)',
            ],
            [
                'name' => 'Healthy & Safe Shift',
                'color' => '#008000',
                'description' => "<ul><li>No Health &amp; safety events AND</li><li>The team's H&amp;S Focus was actioned AND</li><li>Critical controls were in place or identified as absent and applied AND</li><li>All live work tasks are identified and signed off by their manager</li></ul>",
                'bg_color' => 'rgba(0, 128, 0, 0.3)',
            ],
            [
                'name' => 'Less Healthy or Safe Shift',
                'color' => '#ffff00',
                'description' => "<ul><li>A First Aid Injury OR</li><li>Procedures and Standards were not followed OR</li><li>Unexpected Incident</li><li>Hazard not reported or controlled</li></ul>",
                'bg_color' => 'rgba(255, 255, 0, 0.3)',
            ],
            [
                'name' => 'Unhealthy and/or less Safe Shift',
                'color' => '#ff0000',
                'description' => "<ul><li>We had a Recordable Injury OR</li><li>We had a Significant Potential Event OR</li><li>Live Work was completed without Manager sign off OR</li><li>A critical control was not in place and task was not stopped</li></ul>",
                'bg_color' => 'rgba(255, 0, 0, 0.3)',
            ]
        ];

        foreach ($crossCriterias as $crossCriteria) {
            CrossCriteria::create($crossCriteria);
        }
    }
}
