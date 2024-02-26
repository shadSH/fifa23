<?php

function sendNotification($order_id, $registrationIDs, $title, $message, $type, $notificationSound = 'default', $notificationColor = '#203E78')
{
    // API access key from Google FCM App Console
    //    define('API_ACCESS_KEY', 'AAAAyspz-l8:APA91bFYPvD5N5idB1VAUeeuW5oRDA8mbCmBXis7RevuqRqRnxcIXj0UVWBc821mcsbgKIGVfXZrydO9NYSH28gMmgXjVJPD_TKBdOKYUjvvalow2TEW6rYEOS_LUuNJ4yOUPRE1IWLM');

    $API_ACCESS_KEY = 'AAAAymarcl4:APA91bHvMn_UaundijaN7ZmN8HRlJJgqzp56F5hoWI2UUWIVUjKeAM_FhTfEQBLYEGWe6W4cX3WbNvQdIKgrnk01pMTPDsVjmkhcie1iGF1T4sNcWWjqeg9ggjTk_r_AcLYVcYTkzkWx';
    // prep the bundle
    // to see all the options for FCM to/notification payload:
    // https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support

    // 'vibrate' available in GCM, but not in FCM
    $fcmMsg = [
        'body' => $message,
        'title' => $title,
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        'sound' => $notificationSound,
        'image' => 'https://homeschool.system.krd/img/homeschool_logo.png',
        'color' => $notificationColor,

    ];

    $fcmFields = [
        // 	'registration_ids' => $registrationIDs,

        'priority' => 'high',
        'notification' => $fcmMsg,
        'data' => [
            'id' => $order_id,
            'type' => $type,
        ],
        'to' => "$registrationIDs",
    ];

    $headers = [
        'Authorization: key='.$API_ACCESS_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
