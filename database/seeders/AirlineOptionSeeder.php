<?php

namespace Database\Seeders;

use App\Models\AirlineOption;
use App\Models\AgentRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirlineOptionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flight = AgentRecord::query()
            ->where('module', 'flights')
            ->where('reference_code', 'FL-2001')
            ->first();

        if (! $flight) {
            return;
        }

        $airlines = [
            [
                'airline_name' => 'Philippine Airlines',
                'airline_code' => 'PR',
                'icon' => '🇵🇭',
                'sort_order' => 1,
                'flights' => [
                    ['departure' => '08:00', 'arrival' => '15:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 35200],
                    ['departure' => '14:00', 'arrival' => '21:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 33900],
                ],
            ],
            [
                'airline_name' => 'Cebu Pacific Air',
                'airline_code' => '5J',
                'icon' => '✈️',
                'sort_order' => 2,
                'flights' => [
                    ['departure' => '06:30', 'arrival' => '14:00', 'duration' => '7h 30m', 'stops' => 1, 'price' => 31500],
                    ['departure' => '12:00', 'arrival' => '19:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 32900],
                ],
            ],
            [
                'airline_name' => 'AirAsia',
                'airline_code' => 'AK',
                'icon' => '🛫',
                'sort_order' => 3,
                'flights' => [
                    ['departure' => '10:00', 'arrival' => '17:30', 'duration' => '7h 30m', 'stops' => 0, 'price' => 29800],
                    ['departure' => '16:00', 'arrival' => '23:30', 'duration' => '7h 30m', 'stops' => 1, 'price' => 27900],
                ],
            ],
        ];

        foreach ($airlines as $airline) {
            AirlineOption::query()->updateOrCreate(
                [
                    'agent_record_id' => $flight->id,
                    'airline_name' => $airline['airline_name'],
                ],
                [
                    'airline_code' => $airline['airline_code'],
                    'icon' => $airline['icon'],
                    'sort_order' => $airline['sort_order'],
                    'flights' => $airline['flights'],
                ]
            );
        }
    }
}