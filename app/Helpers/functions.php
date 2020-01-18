<?php
/*
* @Function:        <pr>
* @Author:          Rishikesh Singh
* @Created On:      <07-03-2019>
* @Last Modified By:
* @Last Modified: 
* @Description:     <This methode print data in array formate>
*/
function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

/*
* @Function:        <unsetData>
* @Author:          Rishikesh Singh
* @Created On:      <07-03-2019>
* @Last Modified By:
* @Last Modified: 
* @Description:     <This methode unsetdata from 'From' request>
*/
function unsetData($dataArray = array(), $unsetDataArray = array())
{

    return array_diff_key($dataArray, array_flip($unsetDataArray));
}

/*
* @Function:        <image_upload_multiple>
* @Author:          Rishikesh Singh
* @Created On:      <08-03-2019>
* @Last Modified By: Rishikesh Singh
* @Last Modified:   <08-03-2019>
* @Description:     <for upload multiple images>
* @Returns:         <image name array>
* @Return Type:     <array>
*/
function image_upload_multiple($request, $fileName)
{

    $files = $request->file($fileName);
    $ab = array();
    foreach ($files as $key => $file) {
        if (!empty($file)) {
            $fileName = 'event_image' . $key . time() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/upload/event_image'), $fileName);
            array_push($ab, $fileName);
        }
    }
    return $ab;
}

/*
* @Function:        <sendSMTPMail>
* @Author:          Rishikesh Singh
* @Created On:      <11-03-2019>
* @Last Modified By: Rishikesh Singh
* @Last Modified:   <08-03-2019>
* @Description:     <For mail send>
* @Returns:         <   >
* @Return Type:     <array>
*/

function sendSMTPMail($view, $mailData)
{
    /* $view = 'mails.set-password';
      $mailData = array(
      'subject' => 'Test',
      'name' => 'Ramayan',
      'email' => 'ramayan@apptology.in',
      'token' => 'test'
      ); */

    if (env('APP_ENV') == 'local') return true;

    \Mail::send($view, $mailData, function ($message) use ($mailData) {
        //pr($mailData);die;
        $message->to($mailData['email'])
            ->from(env('MAIL_FROMEMAIL'), env('FROMNAME'))
            ->subject($mailData['subject'] . ' - ' . env('APP_NAME'));
    });
}


function send_email($userEmail, $detail)
{
    //$userEmail[]= 'hta.connect@gmail.com';
    $title = $detail['title'];
    $mess = $detail['message'];

    Mail::send('admin.mail.broadcastNotificationMail', ['title' => $title, 'description' => $mess], function ($message) use ($userEmail) {
        $message->from('hta.connect@gmail.com', 'HTA TEAM');
        $message->to('hta.connect@gmail.com')->bcc($userEmail)->subject("Notification");
    });

}

/*
* @Function:        <generateCSV>
* @Author:          Rishikesh Singh
* @Created On:      <13-03-2019>
* @Last Modified By: Rishikesh Singh
* @Last Modified:   <13-03-2019>
* @Description:     <For Ganerate CSV>
* @Returns:         <   >
*/

function generateCSV($header, $data, $fileName)
{
    ob_start();
    $fp = fopen('php://output', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));

    header('Content-type: application/xlsx');
    header('Content-Disposition: attachment; filename=' . $fileName);

    fputcsv($fp, $header);

    // $role = get_roles();
    // $app_status = get_application_status();
    // $att_type = get_attendee_type();

    foreach ($data as $singleRecord) {
        fputcsv($fp, $singleRecord);
    }

    fclose($fp);
    ob_flush();
}

/*
* @Function:        <Match url have https or not if not add https in urls>
* @Author:          Rishikesh Singh
* @Created On:      <1-04-2019>
* @Last Modified By: Rishikesh Singh
* @Last Modified: 
* @Description:     <For check url have https or not >
* @Returns:         <   >
*/
function checkUrl($request_url)
{
    if (!empty($request_url)) {
        if (preg_match("@^http?://@", $request_url) != 1) {
            if (preg_match("@^https?://@", $request_url) != 1) {
                $http_url = 'http://' . $request_url;
                return $http_url;
            } else {
                return $request_url;
            }
        } else {
            return $request_url;
        }
    }
    return $request_url;
}

/**
 * Getting cookies data set by javascript.
 * @param $name
 * @return mixed|string
 */
function getCookie($name)
{
    if (isset($_COOKIE[$name])) {
        return $_COOKIE[$name];
    }
    return '';
}

/**
 * delete cookie
 * @param $name
 * @param $path
 */
function unsetCookie($name, $path)
{
    setcookie($name, '', 1, $path);
}