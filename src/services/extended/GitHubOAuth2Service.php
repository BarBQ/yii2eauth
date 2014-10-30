<?php
/**
 * An example of extending the provider class.
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth\services\extended;

class GitHubOAuth2Service extends \barbq\eauth\services\GitHubOAuth2Service
{

	protected function fetchAttributes()
	{
		$info = $this->makeSignedRequest('user');

		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['login'];
		$this->attributes['url'] = $info['html_url'];

		$this->attributes['following'] = $info['following'];
		$this->attributes['followers'] = $info['followers'];
		$this->attributes['public_repos'] = $info['public_repos'];
		$this->attributes['public_gists'] = $info['public_gists'];
		$this->attributes['avatar_url'] = $info['avatar_url'];

		return true;
	}
}