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
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class FacebookApi extends AbstractApi
{
    public function setUp()
    {
        $this->setAppId($this->container->getParameter('akuma_social.facebook.app_id'));
        $this->setAppSecret($this->container->getParameter('akuma_social.facebook.app_secret'));
        FacebookSession::setDefaultApplication($this->getAppId(), $this->getAppSecret());
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
        $session = new FacebookSession($socialToken);
        try {
            return $session->validate();
        } catch (FacebookSDKException $e) {
            /**
             * Can Be found here http://api-portal.anypoint.mulesoft.com/facebook/api/facebook-graph-api/docs/responses
             */
            throw new ApiException($e->getMessage());
        }
    }

    public function getUserObject($socialToken)
    {
        $session = new FacebookSession($socialToken);
        try {
            $session->validate();
            $fb_request = new FacebookRequest($session, 'GET', '/me');
            $response = $fb_request->execute();
            /**
             * @var \Facebook\GraphObject $graphObject
             */
            $graphObject = $response->getGraphObject();
            $userObject = new SocialUserModel();
            $userObject->setId($graphObject->getProperty('id'));
            $userObject->setEmail($graphObject->getProperty('email'));
            $userObject->setFirstName($graphObject->getProperty('first_name'));
            $userObject->setLastName($graphObject->getProperty('last_name'));
            $userObject->setSocial('facebook');
            return $userObject;
        } catch (FacebookSDKException $e) {
        }
        return null;

    }

    public function getLoginUrl()
    {
        return $this->getLoginUrlHelper()->getLoginUrl(array('email'));
    }

    public function getLoginUrlHelper()
    {
        //urlencode'http://darom.akuma.in/facebook/connect',
        return new FacebookRedirectLoginHelper(
            $this->container->get('router')->generate('akuma_social_facebook_connect', array(), Router::ABSOLUTE_URL),
            $this->getAppId(),
            $this->getAppSecret()
        );

    }
}