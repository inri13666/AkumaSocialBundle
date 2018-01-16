<?php

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;

use Akuma\Bundle\SocialBundle\Api\AbstractApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\AbstractToken;
use FOS\UserBundle\Model\User;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class AbstractAuthenticationProvider implements
    AuthenticationProviderInterface,
    ContainerAwareInterface,
    LoggerAwareInterface
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var LoggerInterface
     */
    protected $logger;

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
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     *
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        /** @var AbstractApi $api */
        $api = $this->container->get('akuma_social.' . strtolower($this->getName()) . '.api');
        $class = $api->getProviderTokenClass();

        return $token instanceof $class;
    }

    /**
     * @param TokenInterface $token
     *
     * @return AbstractToken
     */
    public function authenticate(TokenInterface $token)
    {
        /** @var AbstractToken $token */
        if (!$this->supports($token)) {
            throw new AuthenticationException('Unsupported token given');
        }
        $this->logger->debug("{$this->getName()} Provider Login: user load started");

        /** @var AbstractApi $api */
        $api = $this->container->get('akuma_social.' . strtolower($this->getName()) . '.api');

        $userDetails = $api->getUserDetails($token->getSocialToken());
        if (!$userDetails) {
            throw new AuthenticationException("Your credentials are not correct...");
        }
        if (is_null($userDetails->email)) {
            throw new AuthenticationException("Your credentials are not correct...");
        }
        /** @var User $realUser */
        $realUser = $api->findUserByDetails($userDetails);

        if (!$realUser) {
            throw new AuthenticationException("Your credentials are not correct...");
        }
        $tokenClass = $api->getProviderTokenClass();
        /** @var AbstractToken $authenticatedToken */
        $authenticatedToken = new $tokenClass($realUser->getRoles());
        $authenticatedToken->setAuthenticated(true);
        $authenticatedToken->setUser($realUser);
        $authenticatedToken->setSocialToken($token->getSocialToken());

        return $authenticatedToken;
    }

    /**
     * @return string
     */
    abstract function getName();
}

