<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

class Filter
{
    public $isActive = null;
    public $isMember = null;
    public $userType;
    public $lastLoginFrom;
    public $lastLoginTo;
}
