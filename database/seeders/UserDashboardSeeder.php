<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDashboardItem;
use App\Models\UserDashboardProfile;
use App\Models\UserDashboardSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDashboardSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'key' => 'flights',
                'nav_label' => 'Flights',
                'nav_icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8',
                'title' => 'Popular Flights',
                'subtitle' => 'Top routes chosen by travelers',
                'section_type' => 'cards',
                'is_searchable' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'stays',
                'nav_label' => 'Stays',
                'nav_icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                'title' => 'Favorite Hotels',
                'subtitle' => 'Handpicked stays for smooth check-ins',
                'section_type' => 'cards',
                'is_searchable' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'tours',
                'nav_label' => 'Tours',
                'nav_icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                'title' => 'Best Tour Packages',
                'subtitle' => 'Curated experiences for quick planning',
                'section_type' => 'cards',
                'is_searchable' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'settings',
                'nav_label' => 'Settings',
                'nav_icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                'title' => 'Travel Preferences',
                'subtitle' => 'Keep your dashboard aligned with your style',
                'section_type' => 'profile',
                'body' => 'Update your travel preferences, loyalty goals, and saved destinations from one place.',
                'sort_order' => 4,
            ],
            [
                'key' => 'about',
                'nav_label' => 'About',
                'nav_icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'title' => 'About iWander',
                'subtitle' => 'A compact travel workspace for planning faster',
                'section_type' => 'info',
                'body' => 'iWander keeps flights, stays, and tours in one clean dashboard so travelers can review options quickly and move with less friction.',
                'sort_order' => 5,
            ],
        ];

        foreach ($sections as $sectionData) {
            UserDashboardSection::query()->updateOrCreate(
                ['key' => $sectionData['key']],
                $sectionData
            );
        }

        $flightSection = UserDashboardSection::query()->where('key', 'flights')->firstOrFail();
        $staySection = UserDashboardSection::query()->where('key', 'stays')->firstOrFail();
        $tourSection = UserDashboardSection::query()->where('key', 'tours')->firstOrFail();

        // Delete all existing items for these sections to clean up old records
        UserDashboardItem::query()->whereIn('user_dashboard_section_id', [
            $flightSection->id,
            $staySection->id,
            $tourSection->id,
        ])->delete();

        foreach ([
            [$flightSection, [
                ['title' => 'Manila to Tokyo Flight', 'description' => 'Direct flights from Manila to Tokyo with flexible baggage allowance, on-board meals, and comfortable seating for a smooth travel experience.', 'image_url' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=900&q=80', 'price' => 35200, 'currency' => 'PHP', 'is_featured' => true],
            ]],
            [$staySection, [
                ['title' => 'Boracay Beach Resort', 'description' => 'Luxury beachfront resort with stunning ocean views, world-class amenities, and premium service for an unforgettable tropical experience.', 'image_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1400', 'price' => 4500, 'currency' => 'PHP', 'is_featured' => true],
            ]],
            [$tourSection, [
                ['title' => 'Paris City Adventure', 'description' => 'Experience the magic of Paris with guided tours of iconic landmarks, museum visits, Seine river cruise, and local authentic experiences in the city of lights.', 'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1400', 'price' => 95000, 'currency' => 'PHP', 'is_featured' => true],
            ]],
        ] as [$section, $items]) {
            foreach ($items as $index => $itemData) {
                UserDashboardItem::create([
                    'user_dashboard_section_id' => $section->id,
                    'title' => $itemData['title'],
                    'description' => $itemData['description'],
                    'image_url' => $itemData['image_url'],
                    'price' => $itemData['price'],
                    'currency' => $itemData['currency'],
                    'is_featured' => $itemData['is_featured'],
                    'sort_order' => $index + 1,
                    'meta' => [
                        'section_key' => $section->key,
                    ],
                ]);
            }
        }

        User::query()
            ->whereIn('role', ['user', 'staff', 'manager'])
            ->orderBy('id')
            ->get()
            ->each(function (User $user, int $index): void {
                UserDashboardProfile::query()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'home_section_key' => $user->role === 'manager' ? 'tours' : ($user->role === 'staff' ? 'settings' : 'flights'),
                        'trips_count' => 6 + ($index * 2),
                        'points' => 1200 + ($index * 250),
                        'preferred_destination' => $user->role === 'manager' ? 'Paris, France' : ($user->role === 'staff' ? 'Singapore' : 'Tokyo, Japan'),
                        'preferred_travel_style' => $user->role === 'manager' ? 'Premium escape' : ($user->role === 'staff' ? 'Business-friendly' : 'Weekend city break'),
                        'notes' => 'Dashboard profile seeded for demo content.',
                    ]
                );
            });
    }
}