<?php include __DIR__ . '/_header.php'; ?>
<div class="container">
    <h1>Производственный календарь</h1>
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="/calendar"><span class="glyphicon glyphicon-calendar"></span> Календарь</a></li>
        <li class="active"><a href="/calendar/days"><span class="glyphicon glyphicon-star-empty"></span> Выходные дни</a></li>
        <li><a href="/calendar/task"><span class="glyphicon glyphicon-envelope"></span> Текст задания</a></li>
    </ul>
    <div id="days" class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <h2><?= $isNew ? 'Добавить ' : 'Редактировать ' ?></h2>
            <form action="/calendar/save" method="post">
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" name="name" value="<?= $dayoff->name ?>" autofocus required>
                </div>
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input type="date" class="form-control date-input" name="date" value="<?= $isNew ? date('Y-m-d') : $dayoff->date ?>" required placeholder="ГГГГ-ММ-ДД">
                </div>
                <input type="hidden" name="id" value="<?= $dayoff->id ?>">
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a class="btn btn-default" href="javascript:history.back()">Отмена</a>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/_footer.php'; ?>