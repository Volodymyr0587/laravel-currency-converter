<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        select, input[type="number"], button {
            padding: 8px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Currency Converter</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('currency-converter.convert') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="from_currency">From Currency:</label>
            <select id="from_currency" name="from_currency" required>
                <option value="" disabled selected>Select currency</option>
                @foreach ($currencies as $code => $name)
                    <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="to_currency">To Currency:</label>
            <select id="to_currency" name="to_currency" required>
                <option value="" disabled selected>Select currency</option>
                @foreach ($currencies as $code => $name)
                    <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required min="0" step="any">
        </div>

        <button type="submit">Convert</button>
    </form>
</body>
</html>
