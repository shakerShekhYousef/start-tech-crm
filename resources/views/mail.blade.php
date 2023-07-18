@component('mail::message')
    Upcomming payment after 1 month be attention for that<br>
    Payment data:<hr>
    <B>Property:</B> {{ $property }}<br>
    <B>Payment date:</B> {{ $paymentdate }}<br>
    <B>Payment amount:</B> {{ $paymentamount }}<br>
@endcomponent