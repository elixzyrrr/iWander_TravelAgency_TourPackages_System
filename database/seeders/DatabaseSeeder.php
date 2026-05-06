<?php

namespace Database\Seeders;

use App\Models\AgentRecord;
use App\Models\AgentSetting;
use App\Models\AdminSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed role-based demo users
        $this->call(RoleBasedSeeder::class);

        // seed agent-created travel records used by the dashboard and detail pages
        $this->call(AgentRecordSeeder::class);

        // seed airline options for seeded flight records
        $this->call(AirlineOptionSeeder::class);

        // seed hotel room options for seeded hotel records
        $this->call(HotelRoomOptionSeeder::class);

        // seed tour date options for seeded tour records
        $this->call(TourDateOptionSeeder::class);

        // additional random users
        User::factory()->count(6)->create();

        $this->call(UserDashboardSeeder::class);

        foreach ([
            'agency_name' => 'iWander Travel Agency',
            'contact_email' => 'support@iwander.com',
            'phone_number' => '+63 912 345 6789',
            'currency' => 'PHP',
            'address' => '123 Travel Street, Manila, Philippines',
            'email_booking' => '1',
            'email_payment' => '1',
            'email_reminder' => '1',
            'email_newsletter' => '0',
        ] as $name => $value) {
            AdminSetting::query()->updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }

        foreach ([
            'agency_name' => 'iWander Travel Agency',
            'contact_email' => 'support@iwander.com',
            'phone_number' => '+63 912 345 6789',
            'currency' => 'PHP',
            'address' => '123 Travel Street, Manila, Philippines',
            'email_booking' => '1',
            'email_payment' => '1',
            'email_reminder' => '1',
            'email_newsletter' => '0',
        ] as $name => $value) {
            AgentSetting::query()->updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }

        foreach ([
            ['module' => 'bookings', 'reference_code' => 'BK-1001', 'title' => 'Maria Santos Booking', 'contact_name' => 'Maria Santos', 'contact_email' => 'maria.santos@email.com', 'destination' => 'Paris, France', 'travel_type' => 'Flight + Hotel', 'travel_start' => now()->addWeeks(2), 'travel_end' => now()->addWeeks(3), 'amount' => 85000, 'status' => 'confirmed', 'description' => 'Family vacation booking.'],
            ['module' => 'customers', 'reference_code' => 'CU-1001', 'title' => 'Maria Santos', 'contact_name' => 'Maria Santos', 'contact_email' => 'maria.santos@email.com', 'contact_phone' => '+63 917 123 4567', 'destination' => 'Premium Traveler', 'status' => 'active', 'amount' => 425000, 'description' => 'Returning customer.'],
            ['module' => 'flights', 'reference_code' => 'FL-2001', 'title' => 'Manila to Tokyo', 'destination' => 'Tokyo, Japan', 'travel_type' => 'Philippine Airlines', 'travel_start' => now()->addDays(6), 'travel_end' => now()->addDays(6), 'amount' => 35000, 'status' => 'available', 'description' => 'Morning departure with flexible baggage allowance.'],
            ['module' => 'hotels', 'reference_code' => 'HT-3001', 'title' => 'Grand Luxury Resort', 'destination' => 'Boracay, Philippines', 'travel_type' => 'Resort', 'travel_start' => now()->addDays(10), 'travel_end' => now()->addDays(17), 'amount' => 12000, 'status' => 'available', 'description' => 'Beachfront deluxe suite.'],
            ['module' => 'packages', 'reference_code' => 'PK-4001', 'title' => 'Paris Romance Tour', 'destination' => 'Paris, France', 'travel_type' => '7 Days / 6 Nights', 'travel_start' => now()->addMonth(), 'travel_end' => now()->addMonth()->addDays(6), 'amount' => 120000, 'status' => 'published', 'description' => 'Couple getaway package.'],
            ['module' => 'calendar', 'reference_code' => 'CL-5001', 'title' => 'Visa Assistance Follow-up', 'destination' => 'Manila Office', 'travel_type' => 'Meeting', 'travel_start' => now()->addDay(), 'travel_end' => now()->addDay(), 'status' => 'planned', 'description' => 'Calendar reminder for agent.'],
            ['module' => 'messages', 'reference_code' => 'MSG-6001', 'title' => 'Europe Itinerary Request', 'contact_name' => 'Jennifer Lopez', 'contact_email' => 'jennifer.l@email.com', 'status' => 'new', 'description' => 'Custom itinerary for 2-week Europe tour.'],
        ] as $record) {
            AgentRecord::query()->updateOrCreate(
                ['reference_code' => $record['reference_code']],
                $record
            );
        }
    }
}
