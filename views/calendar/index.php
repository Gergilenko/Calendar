<?php include __DIR__ . '/_header.php'; ?>
<div class="container">
    <h1>Производственный календарь</h1>
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a><span class="glyphicon glyphicon-calendar"></span> Календарь</a></li>
        <li><a href="/calendar/days"><span class="glyphicon glyphicon-star-empty"></span> Выходные дни</a></li>
        <li><a href="/calendar/task"><span class="glyphicon glyphicon-envelope"></span> Текст задания</a></li>
    </ul>
    <form class="text-center form-inline" role="form" action="/calendar" method="post">
        <div class="form-group">
            <label for="year">Выбрать год:</label>
            <select class="form-control" id="year" name="year">
                <?php for ($year = $minYear; $year <= $maxYear; $year++): ?>
                    <option<?= ($year == $currentYear) ? ' selected' : '' ?>><?= $year ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-info">Показать</button>
    </form>
    <hr>
    <div id=calendar class="row">
        <?php foreach ($calendar as $month => $monthArray): ?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4><?= $monthNames[$month] ?></h4></div>
                    <div class="panel-body">
                        <table class="table table-bordered text-center">
                            <thead>
                            <?php foreach ($weekDayNames as $weekDay): ?>
                                <th><?= $weekDay ?></th>
                            <?php endforeach; ?>
                            </thead>
                            <?php foreach($monthArray as $week): ?>
                                <tr>
                                    <?php foreach ($week as $weekDay => $day) {
                                        if (in_array($weekDay, $defaultWeekends)) {
                                            echo '<td class="weekend">' .  $day . '</td>';
                                        }
                                        elseif (!empty($name = array_search($currentYear . '-' . $month . '-' . $day, $daysOff))) {
                                            echo '<td class="dayoff"><span title="' . $name . '"  data-toggle="tooltip">' .  $day . '</span></td>';
                                        }
                                        else {
                                            echo '<td>' .  $day . '</td>';
                                        }
                                    } ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
