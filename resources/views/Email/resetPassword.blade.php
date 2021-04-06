@component('mail::message')
 <head>
    <title>Welcome Email From StaffManager</title>
  </head>
  <body>
    <h2>Welcome to the StaffManager </h2>
    <br/>
     # Your Verification OPT  <br/>
      your OTP is {{$token}}
   </body>

Thanks,<br>
{{ config('app.name') }}
@endcomponent 

