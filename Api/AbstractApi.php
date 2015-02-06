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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractApi implements ContainerAwareInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var mixed
     */
    protected $appId;

    /**
     * @var mixed
     */
    protected $appSecret;

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

    public function getAppId()
    {
        return $this->appId;

    }

    public function getAppSecret()
    {
        return $this->appSecret;
    }

    protected function setAppId($_)
    {
        $this->appId = $_;
    }

    protected function setAppSecret($_)
    {
        $this->appSecret = $_;
    }

    abstract public function setUp();

    /**
     * @param string $socialToken
     *
     * @return bool
     *
     * @throws ApiException
     */
    abstract public function validateToken($socialToken);

    /**
     * @param $socialToken
     *
     * @return SocialUserModel
     */
    abstract public function getUserObject($socialToken);

    abstract public function getLoginUrl();
}