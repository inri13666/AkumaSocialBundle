<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/10/15
 * Time  : 7:29 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\UserBundle\Security\Authentication\EntryPoint;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class GoogleEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * Starts the authentication scheme.
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        //http://stackoverflow.com/questions/10089816/symfony2-how-to-check-if-an-action-is-secured
        file_put_contents('c:/test.txt', __METHOD__ . PHP_EOL, FILE_APPEND);
        // TODO: Implement start() method.
    }
}