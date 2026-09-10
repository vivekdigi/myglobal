@component('mail::message')
# New Demo Account Request

Hello Admin,

A user has submitted a **Demo Account Opening Request**. Details are below:

| Field        | Value |
|--------------|-------|
| **Name**     | {{ $userName }} |
| **Email**    | {{ $userEmail }} |
| **User ID**  | {{ $userId }} |
| **Account ID** | {{ $accountId }} |

Please log in to the admin panel to review and process this request.

@component('mail::button', ['url' => config('app.url') . '/admin/dashboard/demo-requests'])
View Demo Requests
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
