  
    <main>
        <section class="checkout-success-section">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <div class="success-icon mb-4">
                            <i class="fas fa-check-circle text-success fa-5x"></i>
                        </div>
                        <h2 class="mb-4">تم تأكيد طلبك بنجاح!</h2>
                        <div class="success-message mb-4">
                            <?php 
                            if (isset($_SESSION['success_message'])) {
                                echo '<p class="alert alert-success">' . $_SESSION['success_message'] . '</p>';
                                unset($_SESSION['success_message']);
                            }
                            ?>
                        </div>
                        <div class="next-steps">
                            <p class="mb-4">سيتم التواصل معك قريباً لتأكيد طلبك</p>
                            <div class="buttons">
                                <a href="index.php?page=home" class="btn btn-success mb-2">
                                    <i class="fas fa-shopping-bag ml-2"></i>
                                    متابعة التسوق
                                </a>
                                <a href="index.php?page=orders" class="btn btn-outline-secondary">
                                    <i class="fas fa-list ml-2"></i>
                                    عرض طلباتي
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .checkout-success-section {
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .success-icon {
            animation: scaleIn 0.5s ease-in-out;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
            margin: 0 auto;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
        }
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>