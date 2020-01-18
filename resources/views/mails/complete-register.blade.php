@extends('mails.app')
@section('content')
    <tr>
        <td colspan="2" style="font-family: 'open Sans', sans-serif;text-align: center; padding: 30px 0; font-size: 14px;line-height: 22px;">
            <h2 style="margin-top: 12px; text-align: center; margin-bottom: 0; line-height: 30px;">{{ ucwords($name) }}, <br>one more step left</h2>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'open Sans', sans-serif;text-align: center;line-height: 22px; font-size: 14px;">
            <p style="color: #666666">We noticed you have not activated your account yet.</p>
            <p style="color: #666666">Simply click the button below to activate your account and earn</p>

            <a href="{{ $url }}" target="_blank" style="padding: 30px 0; display: inline-block"><img src="https://www.sixty13.com/clientimg/ibuytix/active-now.png" style="max-width: 100%" alt="btn"></a>

            <img src="https://www.sixty13.com/clientimg/ibuytix/progress.png" style="max-width: 100%" alt="progress" />
        </td>
    </tr>
@endsection