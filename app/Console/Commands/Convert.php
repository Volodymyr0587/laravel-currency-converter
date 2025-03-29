<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\select;
use Mgcodeur\CurrencyConverter\Facades\CurrencyConverter;


class Convert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts from one currency to another';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currencies = CurrencyConverter::currencies()->get();
        $currencyCodes = array_keys($currencies); // Get only currency codes

        // dd($currencyCodes);

        $amount = text(
            label: 'Enter the amount',
            required: 'Amount is required.',
            validate: fn (string $value) => match (true) {
                (!is_numeric($value)) => 'The amount must be an integer or float.',
                ((float)$value <= 0) => 'The amount must be greater than zero',
                default => null
            }
        );

        $from = select(
            label: 'What currency should I convert from?',
            required: 'Currency is required.',
            options: $currencyCodes,
            scroll: 10,
            hint: 'Select one currency from the list'
        );

        $to = select(
            label: 'What currency should I convert to?',
            required: 'Currency is required.', // Ensure it's required
            options: $currencyCodes,
            scroll: 10,
            hint: 'Select one currency from the list'
        );

        // Ensure valid inputs
        if (!isset($currencies[$from]) || !isset($currencies[$to])) {
            dd('Invalid currency selected.');
        }

        try {
            $convertedAmount = CurrencyConverter::convert((float)$amount)
                ->from($from)
                ->to($to)
                ->get();

            dd($convertedAmount);
        } catch (\Exception $e) {
            Log::error('Currency conversion error: ' . $e->getMessage());
            dd('Conversion failed: ' . $e->getMessage());
        }
    }
}
