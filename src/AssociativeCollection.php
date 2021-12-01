<?php

namespace Phox\Structures;

use Phox\Structures\Interfaces\IAssociativeArray;
use Phox\Structures\Traits\TAssociativeArray;

class AssociativeCollection extends Collection implements IAssociativeArray
{
    use TAssociativeArray;
}