<?php

namespace DjPanel\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DjPanelUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
