<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class CourseBadge extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'Test';

    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints() >= 140;
    }
}
