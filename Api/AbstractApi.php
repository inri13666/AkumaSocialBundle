<?php

namespace Akuma\Bundle\SocialBundle\Api;

use Akuma\Bundle\SocialBundle\Exception\ApiException;
use Akuma\Bundle\SocialBundle\Model\SocialUserModel;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\AbstractToken;
use FOS\UserBundle\Model\UserManager;
use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

abstract class AbstractApi implements ContainerAwareInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var  \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $provider;

    protected function get($what)
    {
        return $this->container->get($what, Container::NULL_ON_INVALID_REFERENCE);
    }

    protected function getParameter($name, $default = null)
    {
        $params = $this->container->getParameterBag();

        return $params->has($name) ? $params->get($name) : $default;
    }

    public function getProviderClass()
    {
        return $this->getParameter('akuma_social.' . strtolower($this->getName()) . '.oauth_provider.class');
    }

    public function getProviderTokenClass()
    {
        return $this->getParameter('akuma_social.' . strtolower($this->getName()) . '.oauth_provider.token.class');
    }

    public function getProviderToken(AccessToken $token)
    {
        $_class = $this->getProviderTokenClass();
        /** @var AbstractToken $pToken */
        $pToken = new $_class;
        $pToken->setSocialToken($token);
        $pToken->setAuthenticated(false);

        return $pToken;
    }

    /**
     * @return \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected function getProviderInstance()
    {
        if (is_null($this->provider)) {
            $_class = $this->getProviderClass();

            $params = array(
                'clientId' => $this->getParameter('akuma_social.' . strtolower($this->getName()) . '.id'),
                'clientSecret' => $this->getParameter('akuma_social.' . strtolower($this->getName()) . '.secret'),
                'redirectUri' => $this->getRedirectUrl(),
            );

            $this->provider = new $_class($params);
            $this->provider->setScopes(
                $this->getParameter(
                    'akuma_social.' . strtolower($this->getName()) . '.scopes',
                    $this->provider->getScopes()
                )
            );
        }

        return $this->provider;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function getLoginUrl(array $options = array())
    {
        return $this->getProviderInstance()->getAuthorizationUrl($options);
    }

    /**
     * @param AccessToken $token
     *
     * @return \League\OAuth2\Client\Entity\User
     */
    public function getUserDetails(AccessToken $token)
    {
        return $this->getProviderInstance()->getUserDetails($token);
    }

    private function getRedirectUrl()
    {
        /** @var Router $router */
        $router = $this->get('router');
        $route = $this->getParameter('akuma_social.' . strtolower($this->getName()) . '.redirect_route');
        if ($route) {
            return $router->generate(
                $this->getParameter(
                    'akuma_social.' . strtolower($this->getName()) . '.redirect_route'
                ),
                array(),
                Router::ABSOLUTE_URL
            );
        }

        return null;
    }

    /**
     * @param Request $request
     *
     * @return AccessToken
     */
    public function getAccessToken(Request $request)
    {
        return $this->getProviderInstance()->getAccessToken(
            'authorization_code',
            array(
                'code' => $request->get('code'),
            )
        );
    }

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @param User $user
     *
     * @return \League\OAuth2\Client\Entity\User
     */
    public function findUserByDetails(User $user)
    {
        /** @var UserManager $userManager */
        $userManager = $this->container->get('fos_user.user_manager');
        $realUser = $userManager->findUserBy(array('email' => $user->email));
        if (!$realUser && ($this->getParameter('akuma_social.auto_create', false))) {
            $realUser = $userManager->createUser();
            $realUser->setEmail($user->email);
            $realUser->setUsername($user->nickname ?: (($user->firstName . ' ' . $user->lastName) ? trim($user->firstName . ' ' . $user->lastName) : $user->email));
            $realUser->setPassword(uniqid());
            $userManager->updateUser($realUser);
        }

        return $realUser;
    }
}
