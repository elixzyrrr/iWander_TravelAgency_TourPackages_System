<?php

namespace Database\Seeders;

use App\Models\AgentRecord;
use App\Models\HotelRoomOption;
use Illuminate\Database\Seeder;

class HotelRoomOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the hotel record (HT-3001 Boracay hotel)
        $hotel = AgentRecord::query()
            ->where('reference_code', 'HT-3001')
            ->where('module', 'hotels')
            ->first();

        if (!$hotel) {
            // Create hotel if it doesn't exist
            $hotel = AgentRecord::create([
                'created_by' => 1,
                'module' => 'hotels',
                'reference_code' => 'HT-3001',
                'title' => 'Boracay Beach Resort',
                'destination' => 'Boracay Island, Philippines',
                'description' => 'Luxury beachfront resort with stunning views',
                'amount' => 4500,
                'cover_image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1400',
                'status' => 'active',
                'details' => [
                    'rating' => 4.7,
                    'reviews' => 389,
                ],
            ]);
        }

        // Create room options for the hotel
        $rooms = [
            [
                'room_type' => 'Standard Room',
                'capacity' => 2,
                'available_rooms' => 8,
                'price_per_night' => 3500,
                'room_description' => 'Cozy oceanview room with modern amenities and comfortable setup',
                'amenities' => ['Air Conditioning', 'WiFi', 'Flat-screen TV', 'Private Bathroom'],
                'sort_order' => 1,
            ],
            [
                'room_type' => 'Deluxe Room',
                'capacity' => 3,
                'available_rooms' => 6,
                'price_per_night' => 5500,
                'room_description' => 'Spacious room with balcony overlooking the beach and premium fixtures',
                'amenities' => ['Air Conditioning', 'WiFi', 'Flat-screen TV', 'Private Bathroom', 'Minibar', 'Bathrobe', 'Beach access'],
                'sort_order' => 2,
            ],
            [
                'room_type' => 'Suite Room',
                'capacity' => 4,
                'available_rooms' => 3,
                'price_per_night' => 4500,
                'room_description' => 'Premium suite with separate living area and oceanfront terrace for ultimate comfort',
                'amenities' => ['Air Conditioning', 'WiFi', 'Flat-screen TV', 'Jacuzzi Tub', 'Minibar', 'Bathrobe', 'Concierge service', 'Breakfast included', 'Beach access'],
                'sort_order' => 3,
            ],
        ];

        foreach ($rooms as $roomData) {
            HotelRoomOption::create([
                'agent_record_id' => $hotel->id,
                ...$roomData,
            ]);
        }

        echo "Hotel room options seeded successfully!\n";
    }
}
