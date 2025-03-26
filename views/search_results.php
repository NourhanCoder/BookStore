<?php
require_once __DIR__ . '/../app/controllers/SearchController.php';

use App\Controllers\SearchController;

$searchController = new SearchController();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchResponse = [
    'type' => 'no_results',
    'results' => []
];

// Debug: Print the search query
error_log("Search query from GET: " . $query);

if (!empty($query)) {
    $searchResponse = $searchController->search($query);
    // Debug: Print the search response
    error_log("Search response type: " . $searchResponse['type']);
    error_log("Number of results: " . count($searchResponse['results']));
}
?>

<!-- Add JavaScript file -->
<script src="public/assets/js/cart-favorites.js"></script>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">نتائج البحث عن: "<?php echo htmlspecialchars($query); ?>"</h2>
            
            <?php if ($searchResponse['type'] === 'error'): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($searchResponse['message']); ?>
                </div>
            <?php elseif ($searchResponse['type'] === 'no_results'): ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    عذراً، الكتاب غير متوفر حالياً في مكتبتنا
                </div>
            <?php else: ?>
                <?php if ($searchResponse['type'] === 'author'): ?>
                    <div class="alert alert-info text-center mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        تم العثور على <?php echo count($searchResponse['results']); ?> كتاب للمؤلف "<?php echo htmlspecialchars($query); ?>"
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <?php foreach ($searchResponse['results'] as $book): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="public/assets/images/<?php echo htmlspecialchars($book['image']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($book['title']); ?>"
                                     style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title text-center mb-3"><?php echo htmlspecialchars($book['title']); ?></h5>
                                    <p class="card-text text-center mb-2">
                                        <small class="text-muted">المؤلف: <?php echo htmlspecialchars($book['author']); ?></small>
                                    </p>
                                    <p class="card-text text-center text-success fw-bold mb-3">
                                        <?php echo htmlspecialchars($book['price']); ?> جنيه
                                    </p>
                                    <div class="d-grid gap-2">
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <button onclick="addToFavorites(<?php echo $book['id']; ?>)" 
                                                    class="btn btn-danger w-100">
                                                <i class="fas fa-heart me-2"></i>إضافة للمفضلة
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button onclick="addToCart(
                                            <?php echo $book['id']; ?>, 
                                            '<?php echo htmlspecialchars($book['title']); ?>', 
                                            <?php echo $book['price']; ?>, 
                                            '<?php echo htmlspecialchars($book['image']); ?>'
                                        )" class="btn btn-success w-100">
                                            <i class="fas fa-cart-plus me-2"></i>إضافة للسلة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 