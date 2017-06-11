<?php

namespace Tyras\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TyrasUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
