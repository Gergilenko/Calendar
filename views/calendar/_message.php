<?php foreach ($message as $type => $msg): ?>
    <div class="alert alert-<?= $type ?>">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= $msg; ?>
    </div>
<?php endforeach; ?>