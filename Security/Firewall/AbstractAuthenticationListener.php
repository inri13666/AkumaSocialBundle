<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:38 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Firewall;


use Akuma\Bundle\SocialBundle\Api\AbstractApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\GoogleToken;
use League\OAuth2\Client\Exception\IDPException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener as AbstractAuthenticationListenerParent;

abstract class AbstractAuthenticationListener extends AbstractAuthenticationListenerParent implements ContainerAwareInterface
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var ParameterBag;
     */
    protected $options;

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
     * @param ParameterBag $options
     */
    public function setOptions(ParameterBag $options = null)
    {
        $this->options = $options;
    }


    /**
     * Performs authentication.
     *
     * @param Request $request A Request instance
     *
     * @return TokenInterface|Response|null The authenticated token, null if full authentication is not possible, or a Response
     *
     * @throws AuthenticationException if the authentication fails
     */
    protected function attemptAuthentication(Request $request)
    {
        $this->logger->debug('Trying to auth using Microsoft Social Service');

        /** @var AbstractApi $api */
        $api = $this->container->get('akuma_social.' . strtolower($this->getName()) . '.api');
        try {
            $token = $api->getAccessToken($request);
        } catch (IDPException $e) {
            throw new AuthenticationException($e->getMessage());
        }
        return $this->authenticationManager->authenticate($api->getProviderToken($token));
    }

    abstract protected function getName();

}