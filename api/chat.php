<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'];

    // Call to LLM API (e.g., OpenAI)
    $apiKey = 'API_KEY_PLACEHOLDER';
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
            'ignore_errors' => true // This will allow us to capture HTTP response codes
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        $error = error_get_last();
        die(json_encode(['error' => $error['message']]));
    }

    $response = json_decode($result, true);

    if (isset($response['error'])) {
        die(json_encode(['error' => $response['error']]));
    }

    echo json_encode(['reply' => $response['choices'][0]['text']]);
}
?>
