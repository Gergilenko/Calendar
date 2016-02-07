<?php

namespace app\controllers;

use app\models\Dayoff;
use app\classes\View;

class CalendarController {

    //Mainpage - Calendar
    public function actionIndex() {

        /* CONF SECTION */
        // Days Off highlighted by default: 6 - Saturday, 7 - Sunday
        $defaultWeekends = [6, 7];
        $monthNames = [1 => "январь", "февраль", "март", "апрель", "май", "июнь",
                      "июль", "август", "сентябрь", "октябрь", "ноябрь" ,"декабрь"];
        $weekDayNames = [1 => "Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"];
        /*  END CONF  */

        // Checking if user has chosen a year for calendar
        if (!empty($_POST['year']) && preg_match("/^([0-9]{4})$/", $_POST['year'])) {
            $currentYear = $_POST['year'];
        }
        else {
            $currentYear = date('Y');
        }

        // Array of days off to highlight in calendar
        $daysOff = [];
        $data = Dayoff::searchByColumn('date', $currentYear);
        if ($data) {
            foreach ($data as $item) {
                $item->date = strtotime($item->date);
                // month and day without zero
                $daysOff[$item->name] = date('Y-n-j', $item->date);
            }
        }

        $calendar =[];

        //Year generate cycle
        for ($month = 1; $month <= 12; $month++) {
            //Ressetting month
            $monthArray = [];
            $day = 1;
            $week = 1;
                                    // Unix time for current month and year
            $daysInMonth = date('t', mktime(0,0,0,$month,1,$currentYear));

            //Month generate cycle
            while (true) {
                for ($weekday = 1; $weekday <= 7; $weekday++) {
                                            // Unix time for current day in month and year
                    $dayOfWeek = date('w', mktime(0, 0, 0, $month, $day, $currentYear));
                    //Make Sunday become 7 day instead of 0
                    if ($dayOfWeek == 0) $dayOfWeek = 7;
                    if($weekday == $dayOfWeek) {
                        $monthArray[$week][$weekday] = $day;
                        if ($day < $daysInMonth) {
                            $day++;
                        }
                        else {
                            break 2;
                        }
                    }
                    else {
                        $monthArray[$week][$weekday] = '&nbsp;';
                    }
                }
                $week++;
            }
            $calendar[$month] = $monthArray;
        }
        $view = new View;
        $view->minYear = date('Y') - 6;
        $view->maxYear = date('Y') + 2;
        $view->currentYear = $currentYear;
        $view->calendar = $calendar;
        $view->monthNames = $monthNames;
        $view->weekDayNames = $weekDayNames;
        $view->defaultWeekends = $defaultWeekends;
        $view->daysOff = $daysOff;

        $view->display('calendar/index.php');

    }

    // List of all days off added
    public function actionDays() {
        $message = [];
        $view = new View;

        if (!empty($_GET['error'])) {
            switch($_GET['error']) {
                case 23000:
                    $message = ['warning' => 'Выходной не сохранен. Введенная дата уже обозначена.'];
                default:
            }
        }
        $view->days = Dayoff::selectAll('ORDER BY date DESC');

        $view->message = $message;
        $view->display('calendar/days.php');
    }

    // Show page with initial task
    public function actionTask() {

        $view = new View;
        $view->display('calendar/task.php');
    }

    // Add/Edit Day off
    public function actionEdit() {
        $message = [];

        $view = new View;
        $view->isNew = true;
        // If we have date data - then Editing
        if (!empty($_GET['date'])) {
            //Checking date format
            if (preg_match(DATE_PATTERN, $_GET['date'])) {
                $view->isNew = false;
                $date = $_GET['date'];
                //selectByColumn returns an array of objects, so we take 1st element
                $view->dayoff = (new Dayoff)->selectByColumn('date', $date)[0];
            } else {
                $message = ['danger' => 'Неправильный формат даты.'];
            }
        }
        $view->message = $message;
        $view->display('calendar/edit.php');

    }

    // Save info about Day off
    public function actionSave() {
        $error = 0;

        if (preg_match(DATE_PATTERN, $_POST['date']) && !empty($_POST['name'])) {
            $day = new Dayoff;
            if (!empty($_POST['id'])) {
                $day->id = $_POST['id'];
            }
            $day->name = $_POST['name'];
            $day->date = $_POST['date'];

            try {
                $day->save();
            }
            catch (\PDOException $e) {
                $error = $e->getCode();
            }
        }
        View::redirect('calendar/days?error=' . $error);
    }

    // Deleting info about Day off
    public function actionDelete() {

        if (!empty($_GET['id'])) {
            $day = new Dayoff;
            $day->id = $_GET['id'];
            $day->delete();
        }

        View::redirect('calendar/days');
    }

}