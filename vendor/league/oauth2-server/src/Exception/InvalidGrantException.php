<?php
/**
 * OAuth 2.0 Invalid Grant Exception
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
class InvalidGrantException extends OAuthException
{
    /**
     * {@inheritdoc}
     */
    public $httpStatusCode = 400;

    /**
     * {@inheritdoc}
     */
    public $errorType = 'invalid_grant';

    /**
     * {@inheritdoc}
     */

    public function __construct($parameter)
    {
        $this->parameter = $parameter;
        parent::__construct(
            sprintf(
                '所提供的授权许可无效，过期，撤销，不匹配的URI在授权请求中使用，或发出到另一客户端的重定向。检查 "％s" 参数.',
                $parameter
            )
        );
    }
}
