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
                'color' => '#1976d2',
                'description' => '<p>All</p>',
            ],
            [
                'name' => 'Healthy & Safe Shift',
                'color' => '#7cb342',
                'description' => "<ul><li>No Heallth &amp; safety events AND</li><li>The team's H&amp;S Focus was actioned AND</li><li>Critical controls were in place or identified as absent and applied AND</li><li>All live work ttasks identified aand signed off by their manager</li></ul>",
            ],
            [
                'name' => 'Less Healthy or Safe Shift',
                'color' => '#ffcc32',
                'description' => "<ul><li>A First Aid Injury OR</li><li>Procedures and Standards were not followed OR</li><li>Unexpected Incident</li><li>Hazard not reported or controlled</li></ul>",
            ],
            [
                'name' => 'Unhealthy and/or less Safe Shift',
                'color' => '#f44336',
                'description' => "<ul><li>We had a Reordable Injury OR</li><li>We had a Significant Potential Event OR</li><li>Live Work was completed without Manager sign off OR</li><li>A critical control was not in place and task was not stopped</li></ul>",
            ]
        ];

        foreach ($crossCriterias as $crossCriteria) {
            CrossCriteria::create($crossCriteria);
        }
    }
}
