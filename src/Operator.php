<?php

namespace Phox\Structures;

enum Operator
{
    case Equal;
    case GreaterThan;
    case GreaterThanOrEqual;
    case LessThan;
    case LessThanOrEqual;
    case In;
}
