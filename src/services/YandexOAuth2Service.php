<?php
/**
 * YandexOAuth2Service class file.
 *
 * Register application: https://oauth.yandex.ru/client/my
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth\services;

use OAuth\Common\Token\TokenInterface;
use barbq\eauth\oauth2\Service;

/**
 * Yandex OAuth provider class.
 *
 * @package application.extensions.eauth.services
 */
class YandexOAuth2Service extends Service
{

	protected $name = 'yandex_oauth';
	protected $title = 'Yandex';
	protected $type = 'OAuth2';
	protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));
	protected $tokenDefaultLifetime = TokenInterface::EOL_NEVER_EXPIRES;

	protected $scope = array();
	protected $providerOptions = array(
		'authorize' => 'https://oauth.yandex.ru/authorize',
		'access_token' => 'https://oauth.yandex.ru/token',
	);

	protected function fetchAttributes()
	{
		$info = $this->makeSignedRequest('https://login.yandex.ru/info');

    $this->attributes['id'] = $info['id'];
    $this->attributes['first_name'] = $info['first_name'];
    $this->attributes['last_name'] = $info['last_name'];
    $this->attributes['email'] = $info['default_email'];
    $this->attributes['birthdate'] = $info['birthday'];
    $this->attributes['gender'] = $info['sex'];

		return true;
	}

}