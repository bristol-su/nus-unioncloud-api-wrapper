<?php

namespace Twigger\UnionCloud;

use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Auth\IAuthenticator;
use Twigger\UnionCloud\Exception\Authentication\AuthenticatorNotFound;
use Twigger\UnionCloud\Exception\Authentication\BaseUnionCloudAuthenticationException;
use Twigger\UnionCloud\Request;

/**
 * @package    UnionCloud
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */
class UnionCloud
{

    /**
     * @var null|Authentication
     */
    protected $authentication = null;

    protected $configuration;

    /**
     * UnionCloud constructor.
     *
     * Creates an Authentication instance
     *
     * @param null $authParams
     * @param string $authenticator
     */
    public function __construct($authParams = null, $authenticator=null)
    {
        $this->authentication = new Authentication($authParams, $authenticator);
        $this->configuration = new Configuration();
    }

    /**
     * Manually set the authenticator
     *
     * @param IAuthenticator $authenticator
     *
     * @throws BaseUnionCloudAuthenticationException
     */
    public function setAuthenticator($authenticator)
    {
        $this->authentication->setAuthenticator($authenticator);
    }

    /**
     * Check UnionCloud is ready for the request
     *
     * @throws AuthenticatorNotFound
     *
     * @return void
     */
    private function checkReadyForRequest()
    {
        if(! $this->authentication->hasAuthentication())
        {
            throw new AuthenticatorNotFound();
        }
        return;
    }

    public function setBaseURL($baseURL)
    {
        $this->configuration->setBaseUrl($baseURL);
    }

    public function setMode($mode)
    {
        $this->configuration->setMode($mode);
    }

    /**
     * Retrieves a new Event Request
     *
     * @return Request\EventRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function events()
    {
        $this->checkReadyForRequest();
        return new Request\EventRequest($this->authentication, $this->configuration);
    }

}