<?php

namespace App\Enums;


enum OrderStatusEnum: int
{
    case PENDING = 0;
    case SUCCESS = 1;
    case FAILED = 2;
}
