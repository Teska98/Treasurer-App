<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentRequest>
 */
class PaymentRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => fake() -> realText($maxNbChars = 20, $indexSize = 2),
            'project' => fake() -> company(),
            'person' => fake() -> name(),
            'reciept_number' => fake() -> ean13(),
            'reciept_date' => fake() -> date(),
            'cost' => fake() -> randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 200),
            'bank_account_number' => fake() -> bankAccountNumber(),
            'comment' => fake() -> bs(),
            'image' => 'slika.png'
        ];
    }
}
