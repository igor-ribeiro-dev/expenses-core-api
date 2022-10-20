<?php

namespace App\Services\Internal\Expenses;

use DateTime;

trait DateStringConverter {

    protected function dateStringToDate($dateString): DateTime {
        return \DateTime::createFromFormat('d/m/Y', $dateString);
    }

}