<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/12/15
 * Time  : 9:20 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\UserBundle\Security\Authentication\EntryPoint;


use Akuma\Bundle\SocialBundle\Api\AbstractApi;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\HttpUtils;

abstract class SocialAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var AbstractApi
     */
    protected $api;

    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $options;

    private $loginPath;
    private $useForward;
    private $httpKernel;
    private $httpUtils;

    /**
     * Constructor.
     *
     * @param HttpKernelInterface $kernel
     * @param HttpUtils           $httpUtils  An HttpUtils instance
     * @param string              $loginPath  The path to the login form
     * @param Boolean             $useForward Whether to forward or redirect to the login form
     * @param array               $options
     */
    public function __construct(HttpKernelInterface $kernel, HttpUtils $httpUtils, $loginPath, $useForward = false, array $options = array())
    {
        $this->httpKernel = $kernel;
        $this->httpUtils = $httpUtils;
        $this->loginPath = $loginPath;
        $this->useForward = (Boolean)$useForward;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($this->useForward) {
            $subRequest = $this->httpUtils->createRequest($request, $this->loginPath);

            $response = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
            if (200 === $response->getStatusCode()) {
                $response->headers->set('X-Status-Code', 401);
            }

            return $response;
        }

        return $this->httpUtils->createRedirectResponse($request, $this->loginPath);
    }

    public function setApi(AbstractApi $api)
    {
        $this->api = $api;
    }
} 