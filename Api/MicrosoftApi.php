<?php

namespace Akuma\Bundle\SocialBundle\Api;

use Akuma\Bundle\SocialBundle\Exception\ApiException;
use Akuma\Bundle\SocialBundle\Model\SocialUserModel;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class MicrosoftApi extends AbstractApi
{

    /**
     * @return string
     */
    public function getName()
    {
        return "Microsoft";
    }
}
