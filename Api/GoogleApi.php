<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 9:55 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Api;


use Akuma\Bundle\SocialBundle\Exception\ApiException;

class GoogleApi extends AbstractApi
{

    public function setUp()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param string $socialToken
     *
     * @return bool
     *
     * @throws ApiException
     */
    public function validateSocialToken($socialToken)
    {
        // TODO: Implement validateSocialToken() method.
    }

    public function getUserSocialId($socialToken)
    {
        // TODO: Implement getUserSocialId() method.
    }

    public function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.
    }
}