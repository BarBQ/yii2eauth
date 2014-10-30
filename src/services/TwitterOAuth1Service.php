<?php
/**
 * TwitterOAuthService class file.
 *
 * Register application: https://dev.twitter.com/apps/new
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth\services;

use OAuth\OAuth1\Token\TokenInterface;
use barbq\eauth\oauth1\Service;


/**
 * Twitter provider class.
 *
 * @package application.extensions.eauth.services
 */
class TwitterOAuth1Service extends Service
{

	protected $name = 'twitter';
	protected $title = 'Twitter';
	protected $type = 'OAuth1';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $providerOptions = array(
		'request' => 'https://api.twitter.com/oauth/request_token',
		'authorize' => 'https://api.twitter.com/oauth/authenticate', //https://api.twitter.com/oauth/authorize
		'access' => 'https://api.twitter.com/oauth/access_token',
	);
	protected $baseApiUrl = 'https://api.twitter.com/1.1/';
	protected $tokenDefaultLifetime = TokenInterface::EOL_NEVER_EXPIRES;

	/**
	 * @return bool
	 */
	protected function fetchAttributes()
	{
		$info = $this->makeSignedRequest('account/verify_credentials.json');

    $this->attributes['id'] = $info['id'];

    $names = explode(' ', $info['name']);
    if (count($names) == 2) {
      $this->attributes['first_name'] = $names[0];
      $this->attributes['last_name'] = $names[1];
    } else {
      $this->attributes['first_name'] = $info['name'];
      $this->attributes['last_name'] = '';
    }

    $this->attributes['birthdate'] = '';
    $this->attributes['gender'] = '';
    $this->attributes['url'] = 'http://twitter.com/account/redirect_by_id?id=' . $info['id_str'];

		return true;
	}

	/**
	 * Authenticate the user.
	 *
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate()
	{
		if (isset($_GET['denied'])) {
			$this->cancel();
		}

		return parent::authenticate();
	}
}