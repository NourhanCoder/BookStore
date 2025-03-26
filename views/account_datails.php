<?php
require_once 'app/controllers/AccountDetailsController.php';
$controller = new AccountDetailsController();
$user = $controller->getUserDetails();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الحساب</title>
    <link rel="stylesheet" href="public/assets/css/main.min.css" />
</head>
<body>

    
  
    <main>
        <section class="page-top text-center">
            <h2>حسابي</h2>
        </section>

        <section class="section-container profile my-3 my-md-5 py-5 d-md-flex gap-5">
            <div class="profile__right">
                <div class="profile__user mb-3 d-flex gap-3 align-items-center">
                    <div class="profile__user-img rounded-circle overflow-hidden">
                        <img class="w-100" src="public/assets/images/user.png" alt="" />
                    </div>
                    <div class="profile__user-name"><?php echo htmlspecialchars($user['display_name'] ?? 'User'); ?></div>
                </div>
                <ul class="profile__tabs list-unstyled ps-3">
                    <li class="profile__tab">
                        <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=profile">لوحة التحكم</a>
                    </li>
                    <li class="profile__tab">
                        <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=orders">الطلبات</a>
                    </li>
                    <li class="profile__tab active">
                        <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=account_details">تفاصيل الحساب</a>
                    </li>
                    <li class="profile__tab">
                        <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=favourites">المفضلة</a>
                    </li>
                    <li class="profile__tab">
                        <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=logout">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>

            <div class="profile__left mt-4 mt-md-0 w-100">
                <div class="profile__tab-content active">
                    
                    <form class="profile__form border p-3" action="index.php?page=AccountDetailsController" method="post">
                        <div class="d-flex gap-3 mb-3">
                            <div class="w-100">
                                <label class="fw-bold mb-2" for="first-name">الاسم الاول <span class="required">*</span></label>
                                <input type="text" class="form__input" id="first-name" name="first_name" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required />
                            </div>
                            <div class="w-100">
                                <label class="fw-bold mb-2" for="last-name">الاسم الأخير <span class="required">*</span></label>
                                <input type="text" class="form__input" id="last-name" name="last_name" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required />
                            </div>
                        </div>
                        <div class="w-100">
                            <label class="fw-bold mb-2" for="displayed-name">أسم العرض<span class="required">*</span></label>
                            <input type="text" class="form__input" id="displayed-name" name="display_name" value="<?php echo htmlspecialchars($user['display_name'] ?? ''); ?>" required />
                        </div>
                        <div class="w-100 mb-3">
                            <label class="fw-bold mb-2" for="email">البريد الالكتروني<span class="required">*</span></label>
                            <input type="email" class="form__input" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required />
                        </div>
                        <button type="submit" name="update" class="primary-button">تعديل</button>
                    </form>

                    
                     
                    <form class="profile__form border p-3 mt-4" action="index.php?page=AccountDetailsController" method="post">
                        <fieldset>
                            <legend class="fw-bolder">تغيير كلمة المرور</legend>
                            <div class="w-100 mb-3">
                                <label class="fw-bold mb-2" for="curr-password">كلمة المرور الحالية</label>
                                <input type="password" class="form__input" id="curr-password" name="current_password" required />
                            </div>
                            <div class="w-100 mb-3">
                                <label class="fw-bold mb-2" for="new-password">كلمة المرور الجديدة</label>
                                <input type="password" class="form__input" id="new-password" name="new_password" required />
                            </div>
                            <div class="w-100 mb-3">
                                <label class="fw-bold mb-2" for="confirm-password">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form__input" id="confirm-password" name="confirm_password" required />
                            </div>
                            <button type="submit" name="change_password" class="primary-button">تغيير كلمة المرور</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
