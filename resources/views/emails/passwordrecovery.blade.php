<h3>Hi {{ $mailData['name'] }}, </h3>
<p>A password recovery request has been made for your account.</p>
<p>If you wish to reset your password <a href="{{ url('resetpassword/'.$mailData['token']) }}">click here.</a></p>
<p>If you did not make this request or do not wish to change your password, feel free to ignore this email.</p>
<p>Best regards,</p>
<p>The UP Connect Team</p>