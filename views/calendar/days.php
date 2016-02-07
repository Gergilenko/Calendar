<?php include __DIR__ . '/_header.php'; ?>
    <div class="container">
        <h1>Производственный календарь</h1>
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/calendar"><span class="glyphicon glyphicon-calendar"></span> Календарь</a></li>
            <li class="active"><a><span class="glyphicon glyphicon-star-empty"></span> Выходные дни</a></li>
            <li><a href="/calendar/task"><span class="glyphicon glyphicon-envelope"></span> Текст задания</a></li>
        </ul>
        <?php include __DIR__ . '/_message.php'; ?>
        <div id="days" class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <a class="btn btn-primary" href="/calendar/edit">Добавить</a>
                <?php if ($days): ?>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Дата</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($days as $dayoff): ?>
                        <tr>
                            <td><?= $dayoff->name ?></td>
                            <td><?= $dayoff->date ?></td>
                            <td><a href="<?= '/calendar/edit?date='. $dayoff->date ?>" data-toggle="tooltip" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td><a id="<?= $dayoff->id ?>" href="<?= '/calendar/delete?id='. $dayoff->id ?>" data-toggle="tooltip" title="Удалить"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/_footer.php'; ?>
