<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 9:55 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Api;


use Symfony\Component\Routing\Router;

class GoogleApi extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Google';
    }
}