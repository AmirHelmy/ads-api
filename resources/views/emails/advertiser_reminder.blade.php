@component('mail::message')
# Ad Reminder

Hello **{{ $ad->advertiser->name }}**
@component('mail::panel')
You have an ad with #{{ $ad->id }} Number that will start Tomorrow.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
