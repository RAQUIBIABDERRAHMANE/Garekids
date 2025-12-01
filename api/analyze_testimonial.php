<?php
session_start();
require_once __DIR__ . '/../config/groq.php';

header('Content-Type: application/json');

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get the testimonial content
$data = json_decode(file_get_contents('php://input'), true);
$testimonial = $data['content'] ?? '';

if (empty($testimonial)) {
    echo json_encode(['error' => 'No content provided']);
    exit;
}

// Prepare the AI request to analyze sentiment
$messages = [
    [
        'role' => 'system',
        'content' => 'You are a sentiment analysis AI. Analyze the following testimonial and determine if it is positive, negative, or neutral. Also provide a sentiment score from 0 to 1 (where 0 is very negative, 0.5 is neutral, and 1 is very positive). Respond ONLY in JSON format with keys: "sentiment" (positive/negative/neutral) and "score" (0-1). Example: {"sentiment":"positive","score":0.85}'
    ],
    [
        'role' => 'user',
        'content' => $testimonial
    ]
];

// Prepare request to Groq API
$request_data = [
    'model' => GROQ_MODEL,
    'messages' => $messages,
    'temperature' => 0.3,
    'max_tokens' => 100
];

// Make the API call
$ch = curl_init(GROQ_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . GROQ_API_KEY
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'AI analysis failed', 'details' => $response]);
    exit;
}

$response_data = json_decode($response, true);
$ai_response = $response_data['choices'][0]['message']['content'] ?? '';

// Parse the AI response
$analysis = json_decode($ai_response, true);

if (!$analysis || !isset($analysis['sentiment']) || !isset($analysis['score'])) {
    // Try to extract from text if JSON parsing failed
    if (preg_match('/"sentiment"\s*:\s*"(\w+)"/', $ai_response, $matches)) {
        $sentiment = $matches[1];
    } else {
        $sentiment = 'neutral';
    }
    
    if (preg_match('/"score"\s*:\s*([0-9.]+)/', $ai_response, $matches)) {
        $score = floatval($matches[1]);
    } else {
        $score = 0.5;
    }
    
    $analysis = [
        'sentiment' => $sentiment,
        'score' => $score
    ];
}

// Return the analysis
echo json_encode([
    'sentiment' => $analysis['sentiment'],
    'score' => $analysis['score'],
    'is_positive' => ($analysis['sentiment'] === 'positive' && $analysis['score'] >= 0.6)
]);
