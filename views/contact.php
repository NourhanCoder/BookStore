<main class="contact-page">
    <section class="page-top d-flex justify-content-center align-items-center flex-column text-center">
        <div class="page-top__overlay"></div>
        <div class="position-relative">
            <div class="page-top__title mb-3">
                <h2>تواصل معنا</h2>
                
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }

                if (!empty($errors)) {
                    echo '<div class="alert alert-danger">';
                    foreach ($errors as $error) {
                        echo '<p class="m-0">' . $error . '</p>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <div class="page-top__breadcrumb">
                <a class="text-gray" href="index.php">الرئيسية</a> /
                <span class="text-gray">تواصل معنا</span>
            </div>
        </div>
    </section>
    <section class="section-container py-5">
      <div class="row">
        <div class="col-md-6 col-lg-3 mb-3">
          <div class="contact__item h-100 d-flex align-items-center gap-2">
            <div class="contact__icon">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div>
              <h6 class="contact__item-title m-0">اتصل بنا</h6>
              <p class="contact__item-text m-0">01063888667</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
          <div class="contact__item h-100 d-flex align-items-center gap-2">
            <div class="contact__icon">
              <i class="fa-regular fa-envelope"></i>
            </div>
            <div>
              <h6 class="contact__item-title m-0">راسلنا علي الايميل</h6>
              <p class="contact__item-text m-0">eraasoft@gmail.com</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
          <div class="contact__item h-100 d-flex align-items-center gap-2">
            <div class="contact__icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
              <h6 class="contact__item-title m-0">العنوان</h6>
              <p class="contact__item-text m-0">دعم فني على مدار اليوم للإجابة على اي استفسار لديك</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
          <div class="contact__item h-100 d-flex align-items-center gap-2">
            <div class="contact__icon">
              <i class="fa-solid fa-comments"></i>
            </div>
            <div>
              <h6 class="contact__item-title m-0">دعم متواصل</h6>
              <p class="contact__item-text m-0">يمكنك استبدال واسترجاع المنتج في حالة عدم مطابقة المواصفات.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-container contact d-md-flex align-items-center mb-3">
        <div class="contact__side w-50">
            <h4 class="mb-3">يسعدنا تواصلك معنا في أي وقت</h4>
            <p>إذا كنت تواجه أي مشكلة أو ترغب في استرجاع أو استبدال المنتج لا تتردد أبدًا في التواصل معنا.</p>
            <form class="contact__form" action="index.php?page=contact" method="POST">
                <div class="d-flex gap-3 mb-3">
                    <div class="w-50">
                        <label for="name">الاسم<span class="required">*</span></label>
                        <input class="contact__input" id="name" name="name" type="text" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>
                    <div class="w-50">
                        <label for="phone">رقم الهاتف<span class="required">*</span></label>
                        <input class="contact__input" id="phone" name="phone" type="text" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email">البريد الإلكتروني<span class="required">*</span></label>
                    <input class="contact__input" id="email" name="email" type="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="reason">سبب التواصل<span class="required">*</span></label>
                    <select class="contact__input" id="reason" name="reason" required>
                        <option value="">- اختر سبب التواصل -</option>
                        <?php
                        $reasons = ['استفسار', 'استبدال', 'استرجاع', 'استعجال اوردر', 'شكوى', 'اقتراح', 'أخرى'];
                        foreach ($reasons as $r) {
                            $selected = (isset($_POST['reason']) && $_POST['reason'] == $r) ? 'selected' : '';
                            echo "<option value=\"$r\" $selected>$r</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="message">نص الرسالة<span class="required">*</span></label>
                    <textarea class="contact__input" id="message" name="message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                <button class="primary-button w-100 rounded-2">إرسال الطلب</button>
            </form>
        </div>
        <div class="contact__side w-50 text-center">
            <img class="w-100" src="public/assets/images/contact-1.png" alt="">
        </div>
    </section>
    <div class="section-container my-5 px-4">
        <div class="contact__map"></div>
    </div>
</main>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
        <p style="color: green; text-align: center;">تم إرسال الطلب بنجاح!</p>
    <?php endif; ?>
</main>