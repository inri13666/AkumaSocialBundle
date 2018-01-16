<?php

namespace Akuma\Bundle\SocialBundle\Api;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class FacebookApi extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Facebook';
    }
}
