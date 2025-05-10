<div class="col-12 col-md-6 col-lg-4">
    <div class="card shadow-lg p-4">
        <h4 class="card-title text-center mb-4">ورود به سایت</h4>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token('form_login')); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">نام کاربری</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">رمز عبور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/register" class="text-decoration-none">حساب کاربری ندارید ؟</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">ورود</button>
        </form>
    </div>
</div>