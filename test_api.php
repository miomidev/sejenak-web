<?php
$ch = curl_init('https://miomipay.pages.dev/api/trx');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer gopay_a17a1f5c9f4948b3a3c8aa0aa9a473c2',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'order_id' => 'TEST-123',
    'amount' => 1000,
    'link_name' => 'Test',
    'webhook_url' => 'https://sejenak.miomidev.com/api/webhook'
]));
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "Status: $httpcode\n";
echo "Response: $response\n";
