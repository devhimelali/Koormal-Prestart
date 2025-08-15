<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create all shifts first
        $shifts = [
            'A',
            'B',
            'C',
            'D'
        ];

        $shiftModels = [];
        foreach ($shifts as $name) {
            $shiftModels[$name] = Shift::create(['name' => $name]);
        }

        // Step 2: Set linked_shift_id according to your mapping
        $shiftModels['A']->update(['linked_shift_id' => $shiftModels['C']->id]);
        $shiftModels['B']->update(['linked_shift_id' => $shiftModels['D']->id]);
        $shiftModels['C']->update(['linked_shift_id' => $shiftModels['A']->id]);
        $shiftModels['D']->update(['linked_shift_id' => $shiftModels['B']->id]);
    }
}
