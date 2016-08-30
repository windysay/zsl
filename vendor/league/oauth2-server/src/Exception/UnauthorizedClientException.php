<?php
/**
 * OAuth 2.0 Unauthorized Client Exception
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
class UnauthorizedClientException extends OAuthException
{
    /**
     * {@inheritdoc}
     */
    public $httpStatusCode = 400;

    /**
     * {@inheritdoc}
     */
    public $errorType = 'unauthorized_client';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('客户无权使用该方法来请求访问令牌.');
    }
}
