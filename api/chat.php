<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'];

// Call the OpenAI API
$apiKey = getenv('API_KEY');
$url = 'https://api.openai.com/v1/engines/davinci-codex/completions';

$data = [
    'prompt' => $message,
    'max_tokens' => 150
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n" .
                     "Authorization: Bearer $apiKey\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    http_response_code(500);
    echo json_encode(['reply' => 'Sorry, there was an error processing your request.']);
    exit;
}

$response = json_decode($result, true);
echo json_encode(['reply' => $response['choices'][0]['text']]);
?>
