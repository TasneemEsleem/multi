<x-mail::message>
# Welcome ,{{$name}}
You Have request to reset Password

The body of your message.
@component('mail::panel')
Rest Code is : {{$code}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
