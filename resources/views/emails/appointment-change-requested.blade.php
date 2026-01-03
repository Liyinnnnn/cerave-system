<x-mail::message>
# Appointment Change Request

Hello **{{ $appointment->user->name }}**,

You have requested to change your appointment details:

**Current Appointment:**
- Date: {{ \Carbon\Carbon::parse($appointment->date)->format('jS M Y') }}
- Time: {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
- Consultant: {{ $appointment->consultant->name }}

**Requested Changes:**
@if($requestedDate)
- New Date: {{ \Carbon\Carbon::parse($requestedDate)->format('jS M Y') }}
@endif
@if($requestedTime)
- New Time: {{ \Carbon\Carbon::parse($requestedTime)->format('h:i A') }}
@endif
@if($reason)
- Reason: {{ $reason }}
@endif

Your request has been submitted and is awaiting admin approval. We'll notify you once it's reviewed.

<x-mail::button :url="route('appointments.index')">
View My Appointments
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
