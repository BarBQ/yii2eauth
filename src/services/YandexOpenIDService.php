<?php
/**
 * YandexOpenIDService class file.
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth\services;

use barbq\eauth\openid\Service;

/**
 * Yandex provider class.
 *
 * @package application.extensions.eauth.services
 */
class YandexOpenIDService extends Service
{

	protected $name = 'yandex';
	protected $title = 'Yandex';
	protected $type = 'OpenID';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $url = 'http://openid.yandex.ru/';
	protected $requiredAttributes = array(
		'name' => array('fullname', 'namePerson'),
		//'username' => array('nickname', 'namePerson/friendly'),
		//'email' => array('email', 'contact/email'),
	);
	protected $optionalAttributes = array(
		//'gender' => array('gender', 'person/gender'),
		//'birthDate' => array('dob', 'birthDate'),
	);

	protected function fetchAttributes()
	{
		if (isset($this->attributes['username']) && !empty($this->attributes['username'])) {
			$this->attributes['url'] = 'http://openid.yandex.ru/' . $this->attributes['username'];
		}

		//if (isset($this->attributes['birthDate']) && !empty($this->attributes['birthDate']))
		//$this->attributes['birthDate'] = strtotime($this->attributes['birthDate']);

		return true;
	}
}