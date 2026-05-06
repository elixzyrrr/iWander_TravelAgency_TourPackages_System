<?php

namespace Database\Seeders;

use App\Models\AgentRecord;
use App\Models\TourDateOption;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TourDateOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the tour record (PK-4001 Paris tour)
        $tour = AgentRecord::query()
            ->where('reference_code', 'PK-4001')
            ->where('module', 'packages')
            ->first();

        if (!$tour) {
            // Create tour if it doesn't exist
            $tour = AgentRecord::create([
                'created_by' => 1,
                'module' => 'packages',
                'reference_code' => 'PK-4001',
                'title' => 'Paris City Adventure',
                'destination' => 'Paris, France',
                'description' => '7-day guided tour of Paris with museum visits and local experiences',
                'amount' => 95000,
                'cover_image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1400',
                'status' => 'active',
                'details' => [
                    'rating' => 4.9,
                    'reviews' => 512,
                ],
            ]);
        }

        // Create tour date options
        $today = Carbon::now();
        $dates = [
            [
                'departure_date' => $today->copy()->addDays(15)->format('Y-m-d'),
                'return_date' => $today->copy()->addDays(21)->format('Y-m-d'),
                'group_size' => 15,
                'available_slots' => 5,
                'price_per_person' => 95000,
                'tour_description' => 'Summer season tour with extended hours at attractions and premium experiences',
                'included_items' => ['Round-trip flights', '6 nights hotel accommodation', 'Daily breakfast', 'Guided museum tours', 'Eiffel Tower visit', 'Seine river cruise', 'Professional local guide'],
                'excluded_items' => ['Travel insurance', 'Personal expenses', 'Dinner and lunch', 'Gratuities'],
                'sort_order' => 1,
            ],
            [
                'departure_date' => $today->copy()->addDays(30)->format('Y-m-d'),
                'return_date' => $today->copy()->addDays(36)->format('Y-m-d'),
                'group_size' => 12,
                'available_slots' => 8,
                'price_per_person' => 85000,
                'tour_description' => 'Spring season tour with comfortable weather and moderate crowds for relaxed touring',
                'included_items' => ['Round-trip flights', '6 nights hotel accommodation', 'Daily breakfast', 'Guided museum tours', 'Eiffel Tower visit', 'Professional local guide'],
                'excluded_items' => ['Travel insurance', 'Personal expenses', 'Dinner and lunch'],
                'sort_order' => 2,
            ],
            [
                'departure_date' => $today->copy()->addDays(45)->format('Y-m-d'),
                'return_date' => $today->copy()->addDays(52)->format('Y-m-d'),
                'group_size' => 18,
                'available_slots' => 12,
                'price_per_person' => 78000,
                'tour_description' => 'Autumn tour with scenic weather, fewer crowds, and exclusive Versailles Palace access',
                'included_items' => ['Round-trip flights', '7 nights hotel accommodation', 'Daily breakfast', 'Guided museum tours', 'Eiffel Tower visit', 'Seine river cruise', 'Versailles Palace tour', 'Professional local guide'],
                'excluded_items' => ['Travel insurance', 'Personal expenses', 'Dinner and lunch'],
                'sort_order' => 3,
            ],
        ];

        foreach ($dates as $dateData) {
            TourDateOption::create([
                'agent_record_id' => $tour->id,
                ...$dateData,
            ]);
        }

        echo "Tour date options seeded successfully!\n";
    }
}
