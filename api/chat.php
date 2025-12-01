<?php
/**
 * Groq AI Chatbot API Endpoint
 */

header('Content-Type: application/json');

// Start session to maintain conversation history
session_start();

// Load configuration
require_once __DIR__ . '/../config/groq.php';

// Get the request data
$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'] ?? '';
$language = $input['language'] ?? 'en';

// Validate input
if (empty($message)) {
    echo json_encode(['error' => 'Message is required']);
    exit;
}

// Check if API key is configured
if (GROQ_API_KEY === 'gsk_YOUR_API_KEY_HERE' || empty(GROQ_API_KEY)) {
    echo json_encode([
        'error' => 'API key not configured',
        'response' => $language === 'fr' 
            ? 'Désolé, le chatbot n\'est pas encore configuré. Veuillez nous contacter directement.'
            : 'Sorry, the chatbot is not configured yet. Please contact us directly.'
    ]);
    exit;
}

// Initialize conversation history
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Add user message to history
$_SESSION['chat_history'][] = [
    'role' => 'user',
    'content' => $message
];

// Keep only last 10 messages to avoid token limits
if (count($_SESSION['chat_history']) > 10) {
    $_SESSION['chat_history'] = array_slice($_SESSION['chat_history'], -10);
}

// Prepare messages for Groq API
$systemPrompt = $language === 'fr' ? CHATBOT_SYSTEM_PROMPT_FR : CHATBOT_SYSTEM_PROMPT;

$messages = [
    ['role' => 'system', 'content' => $systemPrompt]
];

// Add conversation history
$messages = array_merge($messages, $_SESSION['chat_history']);

// Prepare request to Groq API
$requestData = [
    'model' => GROQ_MODEL,
    'messages' => $messages,
    'temperature' => 0.7,
    'max_tokens' => 300,
    'top_p' => 1,
    'stream' => false
];

// Make request to Groq API
$ch = curl_init(GROQ_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . GROQ_API_KEY,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Handle response
if ($httpCode !== 200) {
    $errorMsg = $language === 'fr' 
        ? 'Désolé, je rencontre des difficultés. Veuillez réessayer plus tard.'
        : 'Sorry, I\'m having trouble right now. Please try again later.';
    
    echo json_encode([
        'error' => 'API request failed',
        'response' => $errorMsg
    ]);
    exit;
}

$responseData = json_decode($response, true);

if (!isset($responseData['choices'][0]['message']['content'])) {
    echo json_encode([
        'error' => 'Invalid API response',
        'response' => $language === 'fr' 
            ? 'Une erreur est survenue. Veuillez réessayer.'
            : 'An error occurred. Please try again.'
    ]);
    exit;
}

$botResponse = $responseData['choices'][0]['message']['content'];

// Add bot response to history
$_SESSION['chat_history'][] = [
    'role' => 'assistant',
    'content' => $botResponse
];

// Return response
echo json_encode([
    'response' => $botResponse,
    'usage' => $responseData['usage'] ?? null
]);
