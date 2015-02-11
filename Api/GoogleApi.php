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
use Symfony\Component\Routing\Router;

class GoogleApi extends AbstractApi
{

    public function getClient()
    {
        $client = new \Google_Client();
        $client->setClientId($this->getAppId());
        $client->setClientSecret($this->getAppSecret());
        $client->setRedirectUri($this->container->get('router')->generate('akuma_social_google_connect', array(), Router::ABSOLUTE_URL));
        $client->setScopes($this->getAppScopes());
        //$client->setApplicationName('Google+ server-side flow');
        //$client->setAccessType();
        //$client->setDeveloperKey('YOUR_SIMPLE_API_KEY');
        return $client;
    }

    public function setUp()
    {
        $this->setAppId($this->container->getParameter('akuma_social.google.app_id'));
        $this->setAppSecret($this->container->getParameter('akuma_social.google.app_secret'));
        $this->setAppScopes($this->container->getParameterBag()->get('akuma_social.google.app_scopes'));
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
        $client = $this->getClient();
        $client->setAccessToken($socialToken);
        $oauth = new \Google_Service_Oauth2($client);
        /** @var \Google_Service_Oauth2_Userinfoplus $info */
        $info = $oauth->userinfo_v2_me->get();
        $userModel = new SocialUserModel();
        $userModel->setEmail($info->getEmail());
        $userModel->setFirstName($info->getGivenName());
        $userModel->setLastName($info->getFamilyName());
        $userModel->setId($info->getId());
        $userModel->setPicture($info->getPicture());
        $userModel->setSocial('google');
        return $userModel;
    }

    public function getLoginUrl()
    {
        return $this->getClient()->createAuthUrl();
    }
}