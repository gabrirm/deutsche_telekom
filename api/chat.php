// src/api/chat.php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'];

    // Call to LLM API (e.g., OpenAI)
    $apiKey = getenv('API_KEY');
    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';

    $data = array(
        'prompt' => $message,
        'max_tokens' => 150
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n" .
                         "Authorization: Bearer $apiKey\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);

    echo json_encode(['reply' => $response['choices'][0]['text']]);
}
?>
