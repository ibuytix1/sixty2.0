<!DOCTYPE html>
<html>
<head>
    <title>{{ $data->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body style=" margin: 0 !important; padding: 0 !important;">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
    <tbody>
    <tr>
        <td align="center">
            <table style="max-width: 800px; border:4px solid #d2d6df; margin: 40px 0;" cellspacing="0" cellpadding="0"
                   width="100%" border="0">
                <tbody>
                <tr>
                    <td colspan="2" valign="top" style="padding: 0 10px 0 10px; border-bottom:4px solid #d2d6df;">
                        <p style="line-height: 36px; text-align: right; font-family: 'Source Sans Pro',sans-serif;
                        color: #000; margin: 0px; padding: 10px 0 0 0; font-weight: bold; font-size: 26px;">
                            {{ $data->event->event_title }}
                        </p>
                    </td>
                    <td valign="top" style="padding: 10px; border-left:4px solid #d2d6df;">
                        <div style="text-align: center; position: relative;top: 0px;">
                            <img style="max-width: 150px;" src="{{ asset('/public/email/icon_1.png') }}" alt="iBuyTix">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="top"
                        style="font-family: 'Source Sans Pro',sans-serif;padding: 0 10px 0 10px;border-right:4px solid #d2d6df;">
                        <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                            Time:</label>
                        <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                            {{ date("D, F jS, Y", strtotime($data->event->start_date)) }}
                            <br>{{ date("h:i A", strtotime($data->event->start_time)) }} -
                            {{ date("D, F jS, Y", strtotime($data->event->end_date)) }}
                            <br>{{ date("h:i A", strtotime($data->event->end_time)) }}
                        </p>
                    </td>
                    <td valign="top" style="padding: 0 10px 0 10px;font-family: 'Source Sans Pro',sans-serif;">
                        <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                            Venue:</label>
                        <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                            {{ $data->event->address }} {{ $data->event->address_2 }} {{ $data->event->location }}
                        </p>
                    </td>
                    <td valign="bottom" style="padding: 0 10px 0 10px; border-left:4px solid #d2d6df;">
                        <div style="vertical-align: bottom;"><label
                                    style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                                Code:</label>
                            <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                                #{{ $data->order->id }}
                            </p></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top"
                        style="font-family: 'Source Sans Pro',sans-serif;padding: 0 10px 0 10px;border-top:4px solid #d2d6df;
                        border-bottom:4px solid #d2d6df;">
                        <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">Order
                            Info:</label>
                        <p style="text-align: right;line-height: 26px; color: #000; margin: 0px;">
                            Order {{ $data->order->id }} Ordered By {{ $data->name }} on
                            {{ date("D, F jS, Y h:i A", strtotime($data->order->created_at)) }}
                        </p>
                    </td>
                    <td align="center" rowspan="2" valign="middle"
                        style="padding: 5px;border-top:4px solid #d2d6df;border-left:4px solid #d2d6df;">
                        <img src="{{ $data->barcode_path }}"
                             alt="barcode" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="padding: 10px;font-family: 'Source Sans Pro',sans-serif;">
                        <div style="text-align: center; position: relative;top: 0px;">
                            <img src="{{ $data->barcode_c39 }}" alt="iBuyTix">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>