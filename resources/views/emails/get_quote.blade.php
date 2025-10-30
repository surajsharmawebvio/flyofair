<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Flight Quote Request</title>
</head>
<body>
    <h2>@if(isset($recipient) && $recipient === 'admin') New quote request received @else Thank you for your quote request @endif</h2>

    <p>Trip type: <strong>{{ $data['tripType'] ?? 'N/A' }}</strong></p>

    @if(isset($data['email']))
        <p>Email: {{ $data['email'] }}</p>
    @endif
    @if(isset($data['phone']))
        <p>Phone: {{ $data['phone'] }}</p>
    @endif

    @if($data['tripType'] === 'oneway')
        <p>From: {{ $data['from'] ?? 'N/A' }}</p>
        <p>To: {{ $data['to'] ?? 'N/A' }}</p>
        <p>Departure Date: {{ $data['departureDate'] ?? 'N/A' }}</p>
    @elseif($data['tripType'] === 'round')
        <p>From: {{ $data['from'] ?? 'N/A' }}</p>
        <p>To: {{ $data['to'] ?? 'N/A' }}</p>
        <p>Departure Date: {{ $data['departureDate'] ?? 'N/A' }}</p>
        <p>Return Date: {{ $data['returnDate'] ?? 'N/A' }}</p>
    @elseif($data['tripType'] === 'multi')
        <h4>Trips</h4>
        @if(!empty($data['trips']) && is_array($data['trips']))
            <ul>
                @foreach($data['trips'] as $trip)
                    <li>{{ $trip['from'] ?? 'N/A' }} → {{ $trip['to'] ?? 'N/A' }} on {{ $trip['date'] ?? 'N/A' }}</li>
                @endforeach
            </ul>
        @endif
    @endif

    @if(isset($data['travelerInfo']))
        <p>Travellers / Class: {{ $data['travelerInfo'] }}</p>
    @endif

    <p>Submitted at: {{ now() }}</p>

</body>
</html>
