<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'code' => ShortUrl::generateUniqueCode(),
            'original_url' => fake()->url(),
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
