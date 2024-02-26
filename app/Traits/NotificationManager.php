<?php

namespace App\Traits;

use App\Models\TokenDevice;
use Illuminate\Support\Str;

trait NotificationManager
{
    public function sendNotification($order_id, $registrationIDs, $title, $message, $type, $notificationSound = 'default', $notificationColor = '#203E78')
    {
        $API_ACCESS_KEY = env('FIREBASE_API_ACCESS_KEY');

        $fcmMsg = $this->fcm_message($message, $title, $notificationSound, $notificationColor);

        $fcmFields = $this->fcm_fields($fcmMsg, $order_id, $type, $registrationIDs);

        $headers = $this->get_headers($API_ACCESS_KEY);

        return $this->notification_configure($headers, $fcmFields);
    }

    protected function fcm_message($message, $title, $notificationSound, $notificationColor)
    {
        return [
            'body' => $message,
            'title' => $title,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'sound' => $notificationSound,
            'image' => env('FCM_MESSAGE_IMAGE_URL'),
            'color' => $notificationColor,

        ];
    }

    protected function fcm_fields($fcmMsg, $order_id, $type, $registrationIDs)
    {
        return [
            // 	'registration_ids' => $registrationIDs,
            'priority' => 'high',
            'notification' => $fcmMsg,
            'data' => [
                'id' => $order_id,
                'type' => $type,
            ],
            'to' => "$registrationIDs",
        ];
    }

    protected function get_headers($API_ACCESS_KEY)
    {
        return [
            'Authorization: key='.$API_ACCESS_KEY,
            'Content-Type: application/json',
        ];
    }

    protected function notification_configure($headers, $fcmFields)
    {
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

    public function sendNotificationForUsers($title, $short_description = '')
    {
        $tokenDevices = TokenDevice::query();
        $totalCount = $tokenDevices->count();
        $short_description = Str::limit($short_description, 50, '...');

        if ($totalCount > 0) {
            $chunkSize = 1000; // Define the chunk size that suits your needs

            $tokenDevices->chunk($chunkSize, function ($chunk) use ($title, $short_description) {
                foreach ($chunk as $token) {
                    $this->sendNotification('1', $token->device_id, $title, $short_description, 'all');
                }
            });

            return true;
        } else {
            return false;
        }
    }
}
