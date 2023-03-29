<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

class Filter
{
    public ?int $isActive = null;
    public ?int $isMember = null;
    public ?array $userType = null;
    public ?\DateTime $lastLoginFrom = null;
    public ?\DateTime $lastLoginTo = null;
}
