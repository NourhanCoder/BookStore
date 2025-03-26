<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حساب المستخدم</title>
    <link rel="stylesheet" href="public/assets/css/vendors/all.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/owl.carousel.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/owl.theme.default.min.css">
    <link rel="stylesheet" href="public/assets/css/main.min.css">
</head>

<body>
    <main>
        <div class="page-top d-flex justify-content-center align-items-center flex-column text-center">
            <div class="page-top__overlay"></div>
            <div class="position-relative">
                <div class="page-top__title mb-3">
                    <h2>حسابي</h2>
                </div>
                <div class="page-top__breadcrumb">
                    <a class="text-gray" href="index.php">الرئيسية</a> /
                    <span class="text-gray">حسابي</span>
                </div>
            </div>
        </div>

        <div class="page-full pb-5">
            <div class="account account--login mt-5 pt-5">

                

                <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']); 
                }

                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']); 
                }
                ?>


                
                <ul class="nav nav-tabs justify-content-center" id="accountTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginForm" type="button" role="tab">تسجيل الدخول</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerForm" type="button" role="tab">حساب جديد</button>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="accountTabsContent">
                   
                    <div class="tab-pane fade show active" id="loginForm" role="tabpanel">
                        <form action="index.php?page=accountController" method="POST" class="mb-5">
                            <div class="input-group rounded-1 mb-3">
                                <input type="email" class="form-control p-3" name="email" placeholder="البريد الإلكتروني" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-envelope"></i></span>
                            </div>
                            <div class="input-group rounded-1 mb-3">
                                <input type="password" class="form-control p-3" name="password" placeholder="كلمة السر" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-key"></i></span>
                            </div>
                            <div class="login__bottom d-flex justify-content-between mb-3">
                                <a class="login__forget-btn" href="index.php?page=forgot_password">نسيت كلمة المرور؟</a>
                                <div>
                                    <input type="checkbox" name="remember">
                                    <label>تذكرني</label>
                                </div>
                            </div>
                            <button type="submit" name="login" class="text-center fs-6 py-2 w-100 bg-black text-white border-0 rounded-1">تسجيل الدخول</button>
                        </form>
                    </div>

                    
                    <div class="tab-pane fade" id="registerForm" role="tabpanel">
                        <form action="index.php?page=accountController" method="POST" class="mb-5">
                            <div class="input-group rounded-1 mb-3">
                                <input type="text" class="form-control p-3" name="name" placeholder="الاسم الكامل" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-user"></i></span>
                            </div>
                            <div class="input-group rounded-1 mb-3">
                                <input type="password" class="form-control p-3" name="password" placeholder="كلمة السر" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-key"></i></span>
                            </div>
                            <div class="input-group rounded-1 mb-3">
                                <input type="password" class="form-control p-3" name="confirm_password" placeholder="تأكيد كلمة السر" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-key"></i></span>
                            </div>
                            <div class="input-group rounded-1 mb-3">
                                <input type="email" class="form-control p-3" name="email" placeholder="البريد الإلكتروني" required>
                                <span class="input-group-text login__input-icon"><i class="fa-solid fa-envelope"></i></span>
                            </div>
                            <button type="submit" name="register" class="text-center fs-6 py-2 w-100 bg-black text-white border-0 rounded-1">حساب جديد</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

   
    <script src="public/assets/js/vendors/all.min.js"></script>
    <script src="public/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="public/assets/js/vendors/jquery-3.7.0.js"></script>
    <script src="public/assets/js/vendors/owl.carousel.min.js"></script>
    <script src="public/assets/js/app.js"></script>
</body>

</html>