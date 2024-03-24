<?php

namespace App\Enums;

enum ConfirmationStatuses: int
{
    case  CONFIRMED = 1;
    case REJECTED = 2;
}
