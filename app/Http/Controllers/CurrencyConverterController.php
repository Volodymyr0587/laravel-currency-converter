<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mgcodeur\CurrencyConverter\Facades\CurrencyConverter;

class CurrencyConverterController extends Controller
{
    public function index()
    {
        $currencies = CurrencyConverter::currencies()->get();
        return view('currency-converter.index', compact('currencies'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $convertedAmount = CurrencyConverter::convert($request->amount)
                ->from($request->from_currency)
                ->to($request->to_currency)
                ->get();

            return back()->with('success', "Converted amount: {$convertedAmount} {$request->to_currency}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
