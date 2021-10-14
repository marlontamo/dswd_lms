<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class PageVisit extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 50;
    public $allowDuplicates = false;
    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct($name)
    {
        $this->subject = \Auth::user();
        $this->name = $name;
    }



    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        return  $this->subject;
    }
}
