<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PremiumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('premium')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $plans = [
            [
                'title' => 'Basic',
                'description' => 'Recurring subscription for 5 listings promoted in search results',
                'monthly_price' => 9,
                'monthly_identifier'    => 'prod_K9eQ2rJy6M6gD0',
                'yearly_identifier'    => 'prod_K9ckt01R2QCf9n',
                'stripe_monthly_id'     => 'price_1JVL7xHN2evfwF1B7ANoOoB6',
                'stripe_yearly_id'     => 'price_1JVJVBHN2evfwF1BKPxYnQDL',
                'yearly_price' => 97,
                'listing' => 5,
                'visibility_days' => 7,
            ],
            [
                'title' => 'Standard',
                'description' => 'Recurring subscription for 15 listings promoted in search results',
                'monthly_price' => 14,
                'monthly_identifier'    => 'prod_K9eRf0He2JI9dx',
                'yearly_identifier'    => 'prod_K9dbzoZGSZdY0H',
                'stripe_monthly_id'     => 'price_1JVL94HN2evfwF1BRxbjUL7Y',
                'stripe_yearly_id'     => 'price_1JVKKKHN2evfwF1BUQPXmL9J',
                'yearly_price' => 151,
                'listing' => 15,
                'visibility_days' => 15,
            ],
            [
                'title' => 'Extended',
                'description' => 'Recurring subscription for UNLIMITED listings promoted in search results',
                'monthly_price' => 27,
                'yearly_price' => 291,
                'monthly_identifier'    => 'prod_K9eS0w0YtUQm5D',
                'yearly_identifier'    => 'prod_K9dc6NtL7Cwa0Z',
                'stripe_monthly_id'     => 'price_1JVL9WHN2evfwF1BeRyeNC5r',
                'stripe_yearly_id'     => 'price_1JVKLaHN2evfwF1BcGls8Soo',
                'listing' => 'Unlimited',
                'visibility_days' => 30,
            ],
        ];

        DB::table('premium')->insert($plans);
    }
}