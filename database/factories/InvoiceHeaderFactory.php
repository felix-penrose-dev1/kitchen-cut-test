<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Support\Arr;
use App\Models\InvoiceHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceHeaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceHeader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            'date' => $this->faker->date(),
            'status' => Arr::random([InvoiceHeader::STATUS_DRAFT, InvoiceHeader::STATUS_OPEN, InvoiceHeader::STATUS_PROCESSED]),
        ];
    }
}
