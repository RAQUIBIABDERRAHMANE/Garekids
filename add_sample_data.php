<?php
// Add sample data to database for testing
require_once __DIR__ . '/config/db.php';

echo "<h1>🎨 TakeCare - Add Sample Data</h1>";
echo "<style>
body { 
    font-family: 'Segoe UI', sans-serif; 
    max-width: 800px; 
    margin: 40px auto; 
    padding: 20px; 
    background: linear-gradient(135deg, #FFFEF9 0%, #F0F8FF 50%, #F5F5FF 100%);
}
h1 {
    background: linear-gradient(135deg, #5DADE2, #AF7AC5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.success {
    background: linear-gradient(135deg, rgba(181, 234, 215, 0.3), rgba(125, 206, 160, 0.3));
    border-left: 4px solid #B5EAD7;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;
}
.info {
    background: linear-gradient(135deg, rgba(168, 216, 234, 0.2), rgba(181, 234, 215, 0.2));
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
}
.btn {
    background: linear-gradient(135deg, #A8D8EA, #89CFF0);
    color: #2C3E50;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    margin: 5px;
    font-weight: 600;
}
</style>";

try {
    // Check current data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM testimonials");
    $testimonialsCount = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM gallery");
    $galleryCount = $stmt->fetch()['count'];
    
    echo "<div class='info'>";
    echo "<h2>📊 Current Database Status</h2>";
    echo "<p>✅ Testimonials: <strong>{$testimonialsCount}</strong></p>";
    echo "<p>✅ Gallery Images: <strong>{$galleryCount}</strong></p>";
    echo "</div>";
    
    // Add more testimonials if requested
    if (isset($_POST['add_testimonials'])) {
        $newTestimonials = [
            ['parent_name' => 'Lisa Johnson', 'content' => 'Absolutely wonderful! My twins are so happy here. The staff is patient, kind, and truly cares about the children.'],
            ['parent_name' => 'Robert Chen', 'content' => 'Exceptional childcare service. Our son has developed so many new skills and made great friends. Highly recommended!'],
            ['parent_name' => 'Maria Garcia', 'content' => 'The best childcare in town! Clean, safe environment with engaging activities. My daughter loves it here!'],
            ['parent_name' => 'James Wilson', 'content' => 'Professional and trustworthy. We feel completely at ease leaving our children here every day.'],
            ['parent_name' => 'Sophie Martin', 'content' => 'Amazing experience! The educational programs are top-notch and our kids are thriving.'],
        ];
        
        $added = 0;
        foreach ($newTestimonials as $test) {
            $stmt = $pdo->prepare("INSERT INTO testimonials (parent_name, content) VALUES (?, ?)");
            $stmt->execute([$test['parent_name'], $test['content']]);
            $added++;
        }
        
        echo "<div class='success'>";
        echo "<h3>✅ Added {$added} new testimonials!</h3>";
        echo "</div>";
        
        // Refresh count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM testimonials");
        $testimonialsCount = $stmt->fetch()['count'];
    }
    
    // Show all testimonials
    echo "<div class='info'>";
    echo "<h2>💬 All Testimonials ({$testimonialsCount})</h2>";
    $stmt = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC");
    $all = $stmt->fetchAll();
    
    if ($all) {
        echo "<ol>";
        foreach ($all as $t) {
            echo "<li><strong>" . htmlspecialchars($t['parent_name']) . ":</strong> " 
                 . htmlspecialchars(substr($t['content'], 0, 100)) 
                 . (strlen($t['content']) > 100 ? '...' : '') 
                 . " <em style='color: #6C757D;'>(" . $t['created_at'] . ")</em></li>";
        }
        echo "</ol>";
    }
    echo "</div>";
    
    // Add sample gallery images if requested
    if (isset($_POST['add_gallery'])) {
        $sampleImages = [
            ['caption' => 'Children playing in the playground', 'image_path' => 'https://images.unsplash.com/photo-1587616211892-f0b8b2a4a7c4?w=800'],
            ['caption' => 'Art and creativity class', 'image_path' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800'],
            ['caption' => 'Story time with the kids', 'image_path' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=800'],
            ['caption' => 'Outdoor activities and fun', 'image_path' => 'https://images.unsplash.com/photo-1560785619-c33e2b83bb83?w=800'],
            ['caption' => 'Learning through play', 'image_path' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=800'],
        ];
        
        $added = 0;
        foreach ($sampleImages as $img) {
            $stmt = $pdo->prepare("INSERT INTO gallery (caption, image_path) VALUES (?, ?)");
            $stmt->execute([$img['caption'], $img['image_path']]);
            $added++;
        }
        
        echo "<div class='success'>";
        echo "<h3>✅ Added {$added} gallery images!</h3>";
        echo "</div>";
        
        // Refresh count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM gallery");
        $galleryCount = $stmt->fetch()['count'];
    }
    
    // Show gallery
    echo "<div class='info'>";
    echo "<h2>🖼️ Gallery Images ({$galleryCount})</h2>";
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC LIMIT 10");
    $images = $stmt->fetchAll();
    
    if ($images) {
        echo "<ul>";
        foreach ($images as $img) {
            echo "<li><strong>" . htmlspecialchars($img['caption']) . "</strong> - " 
                 . htmlspecialchars(substr($img['image_path'], 0, 50)) . "...</li>";
        }
        echo "</ul>";
    }
    echo "</div>";
    
    // Action buttons
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<form method='post' style='display: inline;'>";
    echo "<button type='submit' name='add_testimonials' class='btn'>➕ Add More Testimonials</button>";
    echo "</form>";
    
    echo "<form method='post' style='display: inline;'>";
    echo "<button type='submit' name='add_gallery' class='btn'>🖼️ Add Gallery Images</button>";
    echo "</form>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin-top: 40px;'>";
    echo "<a href='index.php' class='btn'>🏠 View Homepage</a>";
    echo "<a href='testimonials.php' class='btn'>💬 View Testimonials Page</a>";
    echo "<a href='gallery.php' class='btn'>🖼️ View Gallery Page</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #fee; padding: 20px; border-left: 4px solid #f00; border-radius: 8px;'>";
    echo "<h3>❌ Error</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
