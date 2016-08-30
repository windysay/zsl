<?php
/**
 * OAuth 2.0 Invalid Scope Exception
 *
 * @package     league/oauth2-server
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace League\OAuth2\Server\Exception;

/**
 * Exception class
 */
class InvalidScopeException extends OAuthException
{
    /**
     * {@inheritdoc}
     */
    public $httpStatusCode = 400;

    /**
     * {@inheritdoc}
     */
    public $errorType = 'invalid_scope';

    /**
     * {@inheritdoc}
     */

    public function __construct($parameter, $redirectUri = null)
    {
        $this->parameter = $parameter;
        parent::__construct(
            sprintf(
                '请求的范围是无效的，未知的，或畸形。检查 "％s" 范围.',
                $parameter
            )
        );

        $this->redirectUri = $redirectUri;
    }
}
