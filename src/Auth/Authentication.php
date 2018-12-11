<?php
/**
 * Authentication Class
 */

namespace Twigger\UnionCloud\Auth;

use Twigger\UnionCloud\Configuration;
use Twigger\UnionCloud\Exception\Authentication\AuthenticationParameterMissing;
use Twigger\UnionCloud\Exception\Authentication\AuthenticatorMustExtendIAuthenticator;
use Twigger\UnionCloud\Exception\Authentication\AuthenticatorNotFound;

/**
 * Thanks to a changeover in the authentication method
 * for the UnionCloud API in late 2018, this package aims
 * to allow for different authenticators to be plugged in.
 *
 * This is a wrapper which controls an authenticator. A
 * class is an authenticator if it extends IAuthenticator.
 *
 * Class Authentication
 * @package Twigger\UnionCloud
 */
class Authentication
{

    /**
     * Implementation of the IAuthenticator interface.
     *
     * This will be used to authenticate the API
     *
     * @var IAuthenticator
     */
    private $authenticator;

    /**
     * Authentication constructor.
     *
     * Creates and populates an authenticator if possible.
     *
     * @param array $authParams
     * @param IAuthenticator $authenticator
     *
     * @throws AuthenticationParameterMissing
     * @throws AuthenticatorNotFound
     */
    public function __construct($authParams = null, $authenticator = null)
    {
        if (is_array($authParams))
        {
            // Find the authenticator class
            if ($authenticator === null) {
                $this->authenticator = new v0Authenticator();
            } elseif ($authenticator instanceof IAuthenticator) {
                $this->authenticator = $authenticator;
            } else {
                throw new AuthenticatorNotFound();
            }

            // Validate and set the parameters
            if (!$this->authenticator->validateParameters($authParams))
            {
                throw new AuthenticationParameterMissing();
            }
            $this->authenticator->setParameters($authParams);
        }
    }

    /**
     * Manually set the Authenticator
     *
     * @param IAuthenticator $authenticator The authenticator to use for authentication
     *
     * @throws AuthenticatorMustExtendIAuthenticator
     *
     * @return void
     */
    public function setAuthenticator($authenticator)
    {
        if ($authenticator instanceof IAuthenticator)
        {
            $this->authenticator = $authenticator;
            return;
        }

        throw new AuthenticatorMustExtendIAuthenticator();
    }


    /**
     * Add authentication options to a GuzzleHTTP request option array.
     *
     * @param array $options
     * @param Configuration $configuration
     *
     * @return array Guzzle HTTP options with authentication options
     */
    public function addAuthentication($options, $configuration)
    {
        if ($this->authenticator->needsRefresh())
        {
            $this->authenticator->authenticate($configuration->getBaseURL());
        }
        return $this->authenticator->addAuthentication($options);
    }

    /**
     * Check the authenticator has been loaded and is ready to be used.
     *
     * @return bool
     */
    public function hasAuthentication()
    {
        if (!$this->authenticator instanceof IAuthenticator)
        {
            return false;
        }
        return true;
    }


}