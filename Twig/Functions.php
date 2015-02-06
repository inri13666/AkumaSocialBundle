<?php
/**
 * User  : Nikita.Makarov
 * Date  : 12/3/14
 * Time  : 7:55 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Twig;


use Akuma\Bundle\SocialBundle\Api\AbstractApi;
use Akuma\Bundle\SocialBundle\Api\FacebookApi;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

class Functions extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array('social_login_url' => new \Twig_Function_Method($this, 'getSocialLoginUrl', array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'akuma_social.twig.functions';
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

    public function getSocialLoginUrl($social)
    {
        /** @var FacebookApi $api */
        $api = $this->container->get('akuma_social.facebook.api');

        return $api->getLoginUrl();
    }
}