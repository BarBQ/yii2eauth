<?php
/**
 * VKontakteOAuth2Service class file.
 *
 * Register application: http://vk.com/editapp?act=create&site=1
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth\services;

use barbq\eauth\oauth2\Service;
use OAuth\OAuth2\Service\ServiceInterface;

/**
 * VKontakte provider class.
 *
 * @package application.extensions.eauth.services
 */
class VKontakteOAuth2Service extends Service
{

	const SCOPE_FRIENDS = 'friends';

	protected $name = 'vkontakte';
	protected $title = 'VK.com';
	protected $type = 'OAuth2';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 350));

	protected $scopes = array(self::SCOPE_FRIENDS);
	protected $providerOptions = array(
		'authorize' => 'http://api.vk.com/oauth/authorize',
		'access_token' => 'https://api.vk.com/oauth/access_token',
	);
	protected $baseApiUrl = 'https://api.vk.com/method/';

	protected function fetchAttributes()
	{
		$tokenData = $this->getAccessTokenData();
		$info = $this->makeSignedRequest('users.get.json', array(
			'query' => array(
				'uids' => $tokenData['params']['user_id'],
				'fields' => '', // uid, first_name and last_name is always available
				//'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
			),
		));

		$info = $info['response'][0];

    $this->attributes['id'] = $info['uid'];
    $this->attributes['first_name'] = $info['first_name'];
    $this->attributes['last_name'] = $info['last_name'];
    $this->attributes['email'] = '';
    $this->attributes['birthdate'] = '';
    $this->attributes['gender'] = $info['sex'] == 1 ? 'female' : 'male';

		return true;
	}

	/**
	 * Returns the error array.
	 *
	 * @param array $response
	 * @return array the error array with 2 keys: code and message. Should be null if no errors.
	 */
	protected function fetchResponseError($response)
	{
		if (isset($response['error'])) {
			return array(
				'code' => is_string($response['error']) ? 0 : $response['error']['error_code'],
//				'message' => is_string($response['error']) ? $response['error'] : $response['error']['error_msg'],
//				'message' => is_string($response['error']) ? $response['error'] : $response['error']['error_msg'],
			);
		} else {
			return null;
		}
	}

	/**
	 * @param array $data
	 * @return string|null
	 */
	public function getAccessTokenResponseError($data)
	{
		if (!isset($data['error'])) {
			return null;
		}
		$error = $data['error'];
		if (isset($data['error_description'])) {
			$error .= ': ' . $data['error_description'];
		}
		return $error;
	}

	/**
	 * Returns a class constant from ServiceInterface defining the authorization method used for the API.
	 *
	 * @return int
	 */
	public function getAuthorizationMethod()
	{
		return ServiceInterface::AUTHORIZATION_METHOD_QUERY_STRING;
	}

}