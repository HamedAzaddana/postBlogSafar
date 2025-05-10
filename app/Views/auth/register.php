<div class="col-12 col-md-6 col-lg-4">
    <div class="card shadow-lg p-4">
        <h4 class="card-title text-center mb-4"> ثبت نام در سایت</h4>
        <form method="POST" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token('form_register')); ?>">
            <div class="mb-3">
                <label for="username"  class="form-label">نام کاربری</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo old_app('username'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" class="form-control" name="email"  id="email" value="<?php echo old_app('email'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">رمز عبور</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">تکرار رمز عبور</label>
                <input type="password" class="form-control" name="password_confirmation"  id="password_confirmation" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/login" class="text-decoration-none">حساب کاربری قبلا ساخته اید ؟</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">ثبت نام</button>
        </form>
    </div>
</div>