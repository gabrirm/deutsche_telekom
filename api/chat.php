<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'];

    // Call to OpenAI API
    $apiKey = 'API_KEY_PLACEHOLDER';
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = array(
        'model' => 'gpt-3.5-turbo', 
        'messages' => array(
            array('role' => 'user', 'content' => $message)
        ),
        'max_tokens' => 150
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n" .
                         "Authorization: Bearer $apiKey\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
            'ignore_errors' => true 
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
        die(json_encode(['error' => $response['error']['message']]));
    }

    echo json_encode(['reply' => $response['choices'][0]['message']['content']]);
}
?>
