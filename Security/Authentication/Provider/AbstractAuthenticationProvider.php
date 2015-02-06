<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:13 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

abstract class AbstractAuthenticationProvider implements AuthenticationProviderInterface, ContainerAwareInterface, LoggerAwareInterface
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
}

