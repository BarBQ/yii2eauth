<?php
/**
 * Extension class file.
 *
 * @author Alexander Nikitin <nikitin-a-g@yandex.ru>
 * @link http://github.com/BarBQ/yii2eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace barbq\eauth;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * This is the bootstrap class for the yii2-eauth extension.
 */
class Bootstrap implements BootstrapInterface
{
	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		Yii::setAlias('@eauth', __DIR__);
	}
}