<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class EnrollCourse extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 50;
    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        return $this->subject;
    }
}
