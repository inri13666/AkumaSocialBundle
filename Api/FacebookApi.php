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
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class FacebookApi extends AbstractApi
{
    protected $scopes = array();

    public function setAppScopes(array $scopes = null)
    {
        $this->scopes = $scopes;
    }

    public function getAppScopes()
    {
        return $this->scopes;
    }

    public function getLoginHelperClass()
    {
        return $this->container->getParameter('akuma_social.facebook.loginhelper.class');
    }

    public function setUp()
    {
        $this->setAppId($this->container->getParameter('akuma_social.facebook.app_id'));
        $this->setAppSecret($this->container->getParameter('akuma_social.facebook.app_secret'));
        $this->setAppScopes($this->container->getParameterBag()->get('akuma_social.facebook.app_scopes'));
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
        return $this->getLoginUrlHelper()->getLoginUrl($this->getAppScopes());
    }

    public function getLoginUrlHelper()
    {
        switch (true) {
            case(('Facebook\FacebookRedirectLoginHelper' === $this->getLoginHelperClass()) || in_array('Facebook\FacebookRedirectLoginHelper', class_implements($this->getLoginHelperClass()))):
                return new FacebookRedirectLoginHelper(
                    $this->container->get('router')->generate('akuma_social_facebook_connect', array(), Router::ABSOLUTE_URL),
                    $this->getAppId(),
                    $this->getAppSecret()
                );
                break;
            case(('Facebook\FacebookCanvasLoginHelper' === $this->getLoginHelperClass()) || in_array('Facebook\FacebookCanvasLoginHelper', class_implements($this->getLoginHelperClass()))):
                return new FacebookCanvasLoginHelper(
                    $this->getAppId(),
                    $this->getAppSecret()
                );
                break;
            case(('Facebook\FacebookJavaScriptLoginHelper' === $this->getLoginHelperClass()) || in_array('Facebook\FacebookJavaScriptLoginHelper', class_implements($this->getLoginHelperClass()))):
                return new FacebookCanvasLoginHelper(
                    $this->getAppId(),
                    $this->getAppSecret()
                );
                break;
        }
        throw new ApiException('Unknown Facebook Login Helper ' . $this->getLoginHelperClass());
    }
}