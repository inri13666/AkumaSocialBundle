<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 9:55 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Api;


use Akuma\Bundle\SocialBundle\Exception\ApiException;
use Akuma\Bundle\SocialBundle\Model\SocialUserModel;

class GoogleApi extends AbstractApi
{


    public function setUp()
    {
        $this->setAppId($this->container->getParameter('akuma_social.facebook.app_id'));
        $this->setAppSecret($this->container->getParameter('akuma_social.facebook.app_secret'));
        $this->setAppScopes($this->container->getParameterBag()->get('akuma_social.facebook.app_scopes'));
    }

    /**
     * @param string $socialToken
     *
     * @return bool
     *
     * @throws ApiException
     */
    public function validateToken($socialToken)
    {
        // TODO: Implement validateToken() method.
    }

    /**
     * @param $socialToken
     *
     * @return SocialUserModel
     */
    public function getUserObject($socialToken)
    {
        // TODO: Implement getUserObject() method.
    }

    public function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}