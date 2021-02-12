<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kitchen Cut tech test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body class="container antialiased bg-gray-900 mx-auto p-4 flex items-center">
        <div class="text-white grid justify-items-stretch">


            {{-- @dump($invoices) --}}

            <form method="get" action="{{ url('/') }}" class="pb-5 table-auto">
                <label>
                    <span class="text-gray-300">Select status</span>
                    <select
                        name="status"
                        class="mt-1 bg-gray-800 rounded-md border-gray-700 shadow-sm focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 text-gray-300">
                        <option value="">all</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ $status == Request::get('status') ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-gray-300">Select location</span>
                    <select
                        name="location"
                        class="mt-1 bg-gray-800 rounded-md border-gray-700 shadow-sm focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 text-gray-300">
                        <option value="">all</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" {{ $location->id == Request::get('location') ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-gray-300">Date From</span>
                    <input
                        type="date"
                        name="dateFrom"
                        value="{{ Request::get('dateFrom') ?? '' }}"
                        class="mt-1 bg-gray-800 rounded-md border-gray-700 shadow-sm focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 text-gray-300"
                    >
                </label>

                <label>
                    <span class="text-gray-300">Date To</span>
                    <input
                        type="date"
                        name="dateTo"
                        value="{{ Request::get('dateTo') ?? '' }}"
                        class="mt-1 bg-gray-800 rounded-md border-gray-700 shadow-sm focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 text-gray-300"
                    >
                </label>

                <button
                    type="submit"
                    class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
                >Submit</button>
            </form>


            <h2 class="text-3xl py-3">List of invoices</h2>

            <table>
                <thead>
                    <th>Invoice ID</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total Value</th>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->location }}</td>
                            <td>{{ $invoice->date }}</td>
                            <td>{{ $invoice->status }}</td>
                            <td>{{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



            <h2 class="text-3xl py-3 pt-10">Totals by location</h2>

            @if ($locationByStatusValue)
                <table>
                    <thead>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Total Value</th>
                    </thead>
                    <tbody>
                        @foreach ($locationByStatusValue as $status)
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td>{{ $status->name }}</td>
                                <td>{{ $status->status }}</td>
                                <td>{{ number_format($status->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="justify-self-center text-2xl py-3 pt-10">Please choose location above to filter this</h3>
            @endif
        </div>
    </body>
</html>
