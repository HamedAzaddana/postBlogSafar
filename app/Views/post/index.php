
<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img style="width: 100%;height:400px;" src="<?= $post['image']; ?>" class="card-img-top" alt="Post image">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($post['title']); ?></h5>
                    <p class="card-text"><?= htmlspecialchars($post['description']); ?></p>
                    <a href="#" class="btn btn-primary">بیشتر ...</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>