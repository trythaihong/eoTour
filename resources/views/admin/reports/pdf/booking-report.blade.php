<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .status-confirmed {
            color: green;
        }
        .status-pending {
            color: orange;
        }
        .status-cancelled {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Report</h1>
        <p>Generated on: {{ $export_date }}</p>
    </div>

    <div class="info">
        @if($filters['customer_search'] ?? false)
            <p><strong>Customer Search:</strong> {{ $filters['customer_search'] }}</p>
        @endif
        @if($filters['start_date'] ?? false)
            <p><strong>Date Range:</strong> {{ $filters['start_date'] }} to {{ $filters['end_date'] ?? 'Now' }}</p>
        @endif
        @if($filters['status'] ?? false)
            <p><strong>Status Filter:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Tour</th>
                <th>Booking Date</th>
                <th>Travel Dates</th>
                <th>People</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $booking->customer_name }}<br>
                        <small>{{ $booking->customer_email }}</small>
                    </td>
                    <td>{{ $booking->tour->name }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td>
                        {{ $booking->tour->start_date->format('M d') }} - 
                        {{ $booking->tour->end_date->format('M d, Y') }}
                    </td>
                    <td>{{ $booking->people_count }}</td>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                    <td class="status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </td>
                </tr>
            @endforeach
            @if($bookings->count() > 0)
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;">Total:</td>
                    <td>{{ $bookings->sum('people_count') }}</td>
                    <td>${{ number_format($bookings->sum('total_price'), 2) }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($bookings->count() == 0)
        <div style="text-align: center; margin-top: 20px;">
            <p>No bookings found with the current filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically. Total Records: {{ $bookings->count() }}</p>
    </div>
</body>
</html>