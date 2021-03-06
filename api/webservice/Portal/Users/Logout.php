<?php
namespace Api\Portal\Users;

/**
 * Users logout action class
 * @package YetiForce.WebserviceAction
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Logout extends \Api\Core\BaseAction
{

	protected $allowedMethod = ['PUT'];

	public function put()
	{
		$db = \App\Db::getInstance('webservice');
		$db->createCommand()->delete("w_#__portal_session", [
			'id' => $this->controller->headers['X-TOKEN'],
		])->execute();
		$db->createCommand()
			->update('w_#__portal_user', [
				'logout_time' => date('Y-m-d H:i:s')
				], ['id' => $this->session->get('id')])
			->execute();
		return true;
	}
}
