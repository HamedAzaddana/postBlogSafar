<div class="mb-3 mt-2 p-2">
    <?php
    if (!empty(session_get('errors', []))): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session_get('errors') as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        session_put('errors', []);
        ?>
    <?php endif; ?>
    <?php
    if (session_get('success', "") && @session_get('success', "")[0]):
    ?>
        <div class="alert alert-success p-2 m-1">
            <ul class="mb-0">
                <?php echo @session_get('success', "")[0]; ?>
            </ul>
        </div>
    <?php
    session_put('success', "");
    endif;
    ?>
</div>