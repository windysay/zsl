<?php
/**
 * OAuth 2.0 Invalid Request Exception
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
class InvalidRequestException extends OAuthException
{
    /**
     * {@inheritdoc}
     */
    public $httpStatusCode = 400;

    /**
     * {@inheritdoc}
     */
    public $errorType = 'invalid_request';

    /**
     * {@inheritdoc}
     */

    public function __construct($parameter, $redirectUri = null)
    {
        $this->parameter = $parameter;
        parent::__construct(
            sprintf(
                '缺少必需的参数要求，包括一个无效的参数值，包括参数不止一次，或者说是不正常的。检查 "％s" 参数.',
                $parameter
            )
        );

        $this->redirectUri = $redirectUri;
    }
}
