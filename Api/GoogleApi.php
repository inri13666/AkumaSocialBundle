<?php

namespace Akuma\Bundle\SocialBundle\Api;

use Symfony\Component\Routing\Router;

class GoogleApi extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Google';
    }
}
