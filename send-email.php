<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $api_url = "https://api.mailersend.com/v1/email";
    $api_key = "mlsn.88ac193c74e2479dff01298f1944960a379efa089e5baf0b8f581955afe82771";
    $payload = json_encode([
        "from" => ["email" => "info@elevenconsultoriasas.com"],
        "to" => [["email" => "elevenconsultoriasas@gmail.com"]],
        "subject" => $data["subject"],
        "html" => $data["html"]
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    http_response_code($http_code);
    echo $response;
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}
