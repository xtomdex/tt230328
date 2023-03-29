<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

class Filter
{
    public ?int $is_active = null;
    public ?int $is_member = null;
    public ?array $user_type = null;
    public ?\DateTime $last_login_from = null;
    public ?\DateTime $last_login_to = null;
}
