<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = 'en';
require_once __DIR__ . '/lang/' . $_SESSION['lang'] . '.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    
    if (empty($content)) {
        $error_message = $_SESSION['lang'] === 'fr' ? 'Veuillez entrer votre témoignage' : 'Please enter your testimonial';
    } elseif (strlen($content) < 20) {
        $error_message = $_SESSION['lang'] === 'fr' ? 'Le témoignage doit contenir au moins 20 caractères' : 'Testimonial must be at least 20 characters';
    } else {
        // Get user name
        $user_id = $_SESSION['user_id'];
        $user_name = '';
        
        if (isset($pdo)) {
            $stmt = $pdo->prepare('SELECT name FROM users WHERE id = ?');
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_name = $user['name'] ?? '';
        } elseif (isset($conn)) {
            $stmt = $conn->prepare('SELECT name FROM users WHERE id = ?');
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $user_name = $user['name'] ?? '';
        }
        
        // Analyze sentiment using Groq AI directly
        require_once __DIR__ . '/config/groq.php';
        
        $messages = [
            [
                'role' => 'system',
                'content' => 'You are a sentiment analysis AI. Analyze the following testimonial and determine if it is positive, negative, or neutral. Also provide a sentiment score from 0 to 1 (where 0 is very negative, 0.5 is neutral, and 1 is very positive). Respond ONLY in JSON format with keys: "sentiment" (positive/negative/neutral) and "score" (0-1). Example: {"sentiment":"positive","score":0.85}'
            ],
            [
                'role' => 'user',
                'content' => $content
            ]
        ];
        
        $request_data = [
            'model' => GROQ_MODEL,
            'messages' => $messages,
            'temperature' => 0.3,
            'max_tokens' => 100
        ];
        
        $ch = curl_init(GROQ_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . GROQ_API_KEY
        ]);
        
        $ai_response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code !== 200) {
            error_log("Groq API error: " . $ai_response);
            $error_message = $_SESSION['lang'] === 'fr' ? 'Erreur lors de l\'analyse du témoignage' : 'Error analyzing testimonial';
        } else {
            $response_data = json_decode($ai_response, true);
            $ai_text = $response_data['choices'][0]['message']['content'] ?? '';
            
            // Parse the AI response
            $analysis = json_decode($ai_text, true);
            
            if (!$analysis || !isset($analysis['sentiment']) || !isset($analysis['score'])) {
                // Try to extract from text if JSON parsing failed
                if (preg_match('/"sentiment"\s*:\s*"(\w+)"/', $ai_text, $matches)) {
                    $sentiment = $matches[1];
                } else {
                    $sentiment = 'neutral';
                }
                
                if (preg_match('/"score"\s*:\s*([0-9.]+)/', $ai_text, $matches)) {
                    $score = floatval($matches[1]);
                } else {
                    $score = 0.5;
                }
                
                $analysis = [
                    'sentiment' => $sentiment,
                    'score' => $score
                ];
            }
            
            $is_positive = ($analysis['sentiment'] === 'positive' && $analysis['score'] >= 0.6);
            $status = $is_positive ? 'approved' : 'rejected';
            $sentiment = $analysis['sentiment'];
            $score = $analysis['score'];
            
            // Insert testimonial - always accept but mark status internally
            if (isset($pdo)) {
                $stmt = $pdo->prepare('INSERT INTO testimonials (parent_name, content, user_id, status, ai_sentiment, ai_score) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$user_name, $content, $user_id, $status, $sentiment, $score]);
            } elseif (isset($conn)) {
                $stmt = $conn->prepare('INSERT INTO testimonials (parent_name, content, user_id, status, ai_sentiment, ai_score) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssissd', $user_name, $content, $user_id, $status, $sentiment, $score);
                $stmt->execute();
            }
            
            // Always show success message to user, regardless of sentiment
            $success_message = $_SESSION['lang'] === 'fr' ? 
                '✅ Merci pour votre témoignage ! Il a été enregistré avec succès.' : 
                '✅ Thank you for your testimonial! It has been successfully recorded.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Laisser un témoignage' : 'Leave a Testimonial'; ?>
        </h1>
        <p class="text-gray-600">
            <?php echo $_SESSION['lang'] === 'fr' ? 
                'Partagez votre expérience avec TakeCare. Les témoignages positifs seront automatiquement affichés sur notre site.' : 
                'Share your experience with TakeCare. Positive testimonials will be automatically displayed on our website.'; ?>
        </p>
    </div>

    <?php if ($success_message): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-start">
        <i class="fas fa-check-circle text-2xl mr-4 mt-1"></i>
        <div>
            <p class="font-semibold mb-1"><?php echo $_SESSION['lang'] === 'fr' ? 'Succès !' : 'Success!'; ?></p>
            <p><?php echo $success_message; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-start">
        <i class="fas fa-exclamation-circle text-2xl mr-4 mt-1"></i>
        <div>
            <p class="font-semibold mb-1"><?php echo $_SESSION['lang'] === 'fr' ? 'Attention' : 'Notice'; ?></p>
            <p><?php echo $error_message; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form method="POST" action="">
            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-semibold mb-2">
                    <?php echo $_SESSION['lang'] === 'fr' ? 'Votre témoignage' : 'Your Testimonial'; ?>
                    <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="6" 
                    required
                    minlength="20"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pastel-blue focus:border-transparent"
                    placeholder="<?php echo $_SESSION['lang'] === 'fr' ? 
                        'Partagez votre expérience avec nos services de garde d\'enfants...' : 
                        'Share your experience with our childcare services...'; ?>"
                ><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                <p class="text-sm text-gray-500 mt-2">
                    <?php echo $_SESSION['lang'] === 'fr' ? 
                        'Minimum 20 caractères.' : 
                        'Minimum 20 characters.'; ?>
                </p>
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 font-bold py-4 px-8 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-105"
                    style="background: linear-gradient(135deg, #5DADE2, #48C9B0); color: white !important; font-size: 1.1rem;"
                >
                    <i class="fas fa-paper-plane"></i>
                    <?php echo $_SESSION['lang'] === 'fr' ? 'Soumettre le témoignage' : 'Submit Testimonial'; ?>
                </button>
                <a 
                    href="testimonials.php" 
                    class="bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-300 transition-all duration-300 flex items-center justify-center gap-2"
                >
                    <i class="fas fa-arrow-left"></i>
                    <?php echo $_SESSION['lang'] === 'fr' ? 'Voir les témoignages' : 'View Testimonials'; ?>
                </a>
            </div>
        </form>
    </div>

    <!-- My Testimonials Section -->
    <?php
    $my_testimonials = [];
    if (isset($pdo)) {
        $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$_SESSION['user_id']]);
        $my_testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif (isset($conn)) {
        $stmt = $conn->prepare('SELECT * FROM testimonials WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $my_testimonials[] = $row;
        }
    }
    ?>

    <?php if (!empty($my_testimonials)): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Mes témoignages' : 'My Testimonials'; ?>
        </h2>
        <div class="space-y-4">
            <?php foreach ($my_testimonials as $t): ?>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 <?php 
                echo $t['status'] === 'approved' ? 'border-green-500' : 
                    ($t['status'] === 'rejected' ? 'border-red-500' : 'border-yellow-500'); 
            ?>">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <?php if ($t['status'] === 'approved'): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $_SESSION['lang'] === 'fr' ? 'Approuvé' : 'Approved'; ?>
                            </span>
                        <?php elseif ($t['status'] === 'rejected'): ?>
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                <i class="fas fa-times-circle"></i>
                                <?php echo $_SESSION['lang'] === 'fr' ? 'Rejeté' : 'Rejected'; ?>
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                <i class="fas fa-clock"></i>
                                <?php echo $_SESSION['lang'] === 'fr' ? 'En attente' : 'Pending'; ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($t['ai_sentiment']): ?>
                            <span class="text-xs text-gray-500">
                                <?php echo $_SESSION['lang'] === 'fr' ? 'Sentiment' : 'Sentiment'; ?>: 
                                <?php echo ucfirst($t['ai_sentiment']); ?> 
                                (<?php echo number_format($t['ai_score'] * 100, 0); ?>%)
                            </span>
                        <?php endif; ?>
                    </div>
                    <span class="text-xs text-gray-400">
                        <?php echo date('M d, Y', strtotime($t['created_at'])); ?>
                    </span>
                </div>
                <p class="text-gray-700"><?php echo htmlspecialchars($t['content']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
?>