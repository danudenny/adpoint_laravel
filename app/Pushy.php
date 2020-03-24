<?php

namespace App;

class Pushy {
    static public function sendPushNotification($data, $to, $options) {
        $apiKey = '3d8ceb0686df3285dde7576d23bb65feb8d9e95f93f7f354054024bf35a32a99';
        $post = $options ?: array();
        $post['to'] = $to;
        $post['data'] = $data;
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.pushy.me/push?api_key=' . $apiKey);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post, JSON_UNESCAPED_UNICODE));
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        $response = @json_decode($result);
        if (isset($response) && isset($response->error)) {
            throw new \Exception('Pushy API returned an error: ' . $response->error);
        }
    }
}