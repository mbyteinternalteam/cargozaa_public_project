<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Coverage',
                'slug' => 'basic',
                'description' => 'Essential protection against theft and unauthorized access.',
                'daily_rate' => 15.00,
                'coverage_details' => [
                    'Theft protection up to RM 50,000',
                    'Unauthorized access coverage',
                    '24/7 incident reporting',
                    'Basic claim processing (5-7 business days)',
                ],
                'icon' => 'shield-check',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Coverage',
                'slug' => 'standard',
                'description' => 'Comprehensive protection covering theft, damage, and natural disasters.',
                'daily_rate' => 30.00,
                'coverage_details' => [
                    'Theft protection up to RM 100,000',
                    'Accidental damage coverage',
                    'Natural disaster protection',
                    'Fire & flood coverage',
                    'Priority claim processing (3-5 business days)',
                    '24/7 emergency hotline',
                ],
                'icon' => 'shield-exclamation',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Coverage',
                'slug' => 'premium',
                'description' => 'All-inclusive protection with maximum coverage and fastest claims.',
                'daily_rate' => 50.00,
                'coverage_details' => [
                    'Full replacement value coverage up to RM 250,000',
                    'All Standard Coverage benefits',
                    'Goods-in-transit protection',
                    'Third-party liability coverage',
                    'Temperature deviation coverage',
                    'Express claim processing (1-2 business days)',
                    'Dedicated claims manager',
                    'Zero deductible',
                ],
                'icon' => 'star',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'No Insurance',
                'slug' => 'none',
                'description' => 'Proceed without insurance coverage. Not recommended.',
                'daily_rate' => 0.00,
                'coverage_details' => [
                    'No coverage provided',
                    'You are responsible for all losses',
                ],
                'icon' => 'x-circle',
                'sort_order' => 99,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Insurance::query()->updateOrCreate(
                ['slug' => $plan['slug']],
                $plan,
            );
        }
    }
}
