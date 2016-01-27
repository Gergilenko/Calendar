<?php

namespace app\models;

use app\classes\AbstractModel;
use app\classes\Db;

/**
 * Class Dayoff
 * @property $id
 * @property $name
 * @property $date
 */

class Dayoff extends AbstractModel {

    protected static $table = 'dayoff';

}