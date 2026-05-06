<?php

namespace Database\Seeders;

use App\Models\AgentRecord;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentRecordSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agentId = User::query()->where('role', 'agent')->value('id')
            ?? User::query()->where('role', 'user')->value('id');

        if (! $agentId) {
            return;
        }

        $records = [
            [
                'reference_code' => 'FL-2001',
                'module' => 'flights',
                'title' => 'Manila to Tokyo Flight',
                'destination' => 'Tokyo, Japan',
                'travel_type' => 'International Flight',
                'travel_start' => now()->addDays(6),
                'travel_end' => now()->addDays(6),
                'amount' => 35200,
                'status' => 'available',
                'description' => 'Direct flights from Manila to Tokyo with flexible baggage allowance, on-board meals, and comfortable seating for a smooth travel experience.',
                'cover_image' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=900&q=80',
                'details' => [
                    'rating' => 4.6,
                    'reviews' => 254,
                    'duration' => '7h 30m',
                    'capacity' => 280,
                    'departure_city' => 'Manila, Philippines',
                    'arrival_city' => 'Tokyo, Japan',
                    'frequency' => 'Daily Flights',
                    'departure_times' => ['08:00', '14:00'],
                    'amenities' => ['Meals included', 'Entertainment system', 'Baggage allowance', 'WiFi available'],
                    'phone' => '+63 2 8851 9000',
                    'email' => 'flights@manilatokyoair.com',
                ],
            ],
            [
                'reference_code' => 'HT-3001',
                'module' => 'hotels',
                'title' => 'Boracay Beach Resort',
                'destination' => 'Boracay Island, Philippines',
                'travel_type' => 'Resort',
                'travel_start' => now()->addDays(10),
                'travel_end' => now()->addDays(17),
                'amount' => 4500,
                'status' => 'available',
                'description' => 'Luxury beachfront resort with stunning ocean views, world-class amenities, and premium service for an unforgettable tropical experience.',
                'cover_image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1400',
                'details' => [
                    'rating' => 4.7,
                    'reviews' => 389,
                    'room_types' => ['Standard', 'Deluxe', 'Suite'],
                    'check_in' => '2:00 PM',
                    'check_out' => '12:00 PM',
                    'amenities' => ['Free WiFi', 'Pool', 'Gym', 'Restaurant', 'Spa', 'Beach Access'],
                    'phone' => '+63 912 345 6789',
                    'email' => 'contact@boracaybeach.com',
                ],
            ],
            [
                'reference_code' => 'PK-4001',
                'module' => 'packages',
                'title' => 'Paris City Adventure',
                'destination' => 'Paris, France',
                'travel_type' => '7 Days / 6 Nights',
                'travel_start' => now()->addMonth(),
                'travel_end' => now()->addMonth()->addDays(6),
                'amount' => 95000,
                'status' => 'published',
                'description' => 'Experience the magic of Paris with guided tours of iconic landmarks, museum visits, Seine river cruise, and local authentic experiences in the city of lights.',
                'cover_image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1400',
                'details' => [
                    'rating' => 4.9,
                    'reviews' => 512,
                    'days' => 7,
                    'nights' => 6,
                    'group_size' => 12,
                    'highlights' => ['Eiffel Tower', 'Louvre Museum', 'Arc de Triomphe', 'Seine Cruise', 'Versailles Palace'],
                    'included' => ['Hotel accommodation', 'Daily breakfast', 'Guided tours', 'Museum entries', 'Transport'],
                    'excluded' => ['Travel insurance', 'Personal expenses', 'Dinner'],
                    'phone' => '+33 1 23 45 67 89',
                    'email' => 'tours@parisadventure.fr',
                ],
            ],
        ];

        foreach ($records as $record) {
            AgentRecord::query()->updateOrCreate(
                ['reference_code' => $record['reference_code']],
                array_merge($record, ['created_by' => $agentId])
            );
        }
    }
}