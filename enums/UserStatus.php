<?php

namespace app\enums;

enum UserStatus: int
{
    case DELETED = 0;
    case INACTIVE = 9;
    case ACTIVE = 10;
}
