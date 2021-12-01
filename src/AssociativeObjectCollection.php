<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

class AssociativeObjectCollection extends ObjectCollection implements IAssociativeArray
{
    use TAssociativeArray;
}