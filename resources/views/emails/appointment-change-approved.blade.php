<x-mail::message>
# Appointment Change Approved ✅

Hello **{{ $appointment->user->name }}**,

Great news! Your appointment change request has been approved.

**Updated Appointment Details:**
- Date: {{ \Carbon\Carbon::parse($appointment->date)->format('jS M Y') }}
- Time: {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
- Consultant: {{ $appointment->consultant->name }}

Please make sure you're available at the new time. We look forward to seeing you!

<x-mail::button :url="route('appointments.show', $appointment)">
View Appointment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
