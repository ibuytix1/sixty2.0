<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i|Quicksand:400,700&display=swap" rel="stylesheet">
</head>
<body>
<table width="600" style="margin: 32px auto; color: #444444;background-color: #F8f9f9; padding-left: 25px; padding-right: 25px;padding-bottom: 20px;" cellpadding="0" cellspacing="">
    <tr>
        <td>
            <table style="padding: 32px 0px; width: 100%;border-radius: 4px;" cellpadding="0" cellspacing="0">
                <thead>
                <tr style="">
                    <th style="text-align: center; justify-content: center;padding-left: 40px;padding-right: 40px; " colspan="2">
                        <img src="{{ asset('public/images/logo-2.jpg') }}" style="margin:0 auto 32px; width: 50%;" alt="Logo" />
                    </th>
                </tr>
                </thead>
                <tbody style="">
                @yield('content')
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="border: 1px solid #DFD7D7; padding: 16px 20px; margin-top: 16px; width: 100%;border-radius: 5px;background: #DFD7D7 ">
                <tr>
                    <td class="vertical-align: middle">
                        <img src="https://www.sixty13.com/clientimg/ibuytix/question-mark.png" alt="image">
                    </td>
                    <td style="line-height: 18px;font-family: 'open Sans', sans-serif;">
                        <p style="font-size: 13px;color: #000;margin: 0;font-weight: bold; margin-bottom: 5px;">Have a Question?</p>
                        <p style="font-size: 11px;color: #777;margin: 0;">CHECK OUT OUR <a href="#" style="color: ff6600;padding-left: 3px;padding-right: 3px;text-decoration: none">  HELP CENTER </a> OR VISIT OUR CONTACT US PAGE</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="border: none;background-color: #f8f8f8; margin-top: 16px; width: 100%;border-radius: 5px;font-size: 12px" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width: 10%;padding-left: 10px">
                        <img style="width: 50px; margin-right: 15px;" src="https://img.icons8.com/nolan/64/000000/ticket.png" alt="image" />
                    </td>
                    <td style="line-height: 18px;font-family: 'open Sans', sans-serif; width: 40%;padding: 5px">
                        <h3 style="font-family: 'quicksand', sans-serif;margin-top: 10px;margin-bottom: 5px;">Create your own event</h3>
                        <p style="color: #777; margin-top: 0;margin-bottom: 10px">Anyone can create, manage, and promote event on iBuytix</p>
                        <a href="#" style="padding: 5px; color: #ff6600;text-decoration: none">Click to Learn More</a>
                    </td>
                    <td style="width: 10%; background: #47c1bf;padding-left: 10px ">
                        <img style=" width: 50px !important;margin-right: 15px;" src="https://img.icons8.com/nolan/64/000000/overtime.png" alt="image" />
                    </td>
                    <td style="line-height: 18px;font-family: 'open Sans', sans-serif; width: 40%;background: #47c1bf; padding: 5px">
                        <h3 style="font-family: 'quicksand', sans-serif;margin-top: 10px;margin-bottom: 5px;color: #ffffff;">Discover events near you</h3>
                        <p style="color: #f8f8f8; margin-top: 0;margin-bottom: 10px">Browse events that matches your person.</p>
                        <a href="#" style="padding: 5px; color: #ff6600;text-decoration: none">Click to view events</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table style="border: none;background-color: #f8f8f8; margin-top: 16px; width: 100%;border-radius: 5px;font-size: 13px;padding: 15px;color: #777; " cellpadding="0" cellspacing="0">
                <tr>
                    <td style="line-height: 24px;font-family: 'open Sans', sans-serif;text-align: center">
                        <p style="margin-bottom:0;margin-top:0;">This email was sent to <a href="#" style="color: #ff6600; text-decoration: none;"> $Recipient Email Address </a></p>
                        <p style="margin-bottom:0;margin-top:0;">If you think this email is an error please report to support@ibuytix.com <a href="#" style="color: #ff6600; text-decoration: none;"> </a></p>
                        <p style="margin-bottom:0;margin-top:0;"><a href="#" style="color: #ff6600;text-decoration: none;">iBuytix</a> | 14820 Hardcastle St. Laurel| Maryland, 20707</p>
                        <p style="margin-bottom:0;margin-top:0;">Copyright © 2019 iBuytix All rights reserved.</p>
                    </td>
                </tr>
            </table>

            <table style="border: none;margin-top: 20px; width: 100%;text-align: center" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align: center">
                        <a href="www.facebook.com/ibuytix"><img src="https://www.sixty13.com/clientimg/ibuytix/facebook.png" alt="facebook"></a>
                        <a href="https://www.instagram.com/ibuytix/"><img src="https://www.sixty13.com/clientimg/ibuytix/insta.png" alt="facebook"></a>
                        <a href="#"><img src="https://www.sixty13.com/clientimg/ibuytix/twitter.png" alt="facebook"></a>
                        <a href="www.linkedin.com/ibuytix"><img src="https://www.sixty13.com/clientimg/ibuytix/linkedin.png" alt="facebook"></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>


</table>
</body>
</html>
