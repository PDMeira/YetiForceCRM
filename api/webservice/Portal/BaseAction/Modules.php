<?php
namespace Api\Portal\BaseAction;

/**
 * Get modules list action class
 * @package YetiForce.WebserviceAction
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Modules extends \Api\Core\BaseAction
{

	/** @var string[] Request methods */
	protected $requestMethod = ['GET'];

	/**
	 * Get modules list
	 * @return string[]
	 */
	public function get()
	{
		\App\User::setCurrentUserId(\App\User::getActiveAdminId());
		$notInParam = ['Reports', 'RecycleBin', 'ModComments'];
		$query = (new \App\Db\Query())->select(['name'])->from('vtiger_tab')
			->where(['and', ['isentitytype' => 1], ['not', ['name' => $notInParam]]])
			->orderBy('name');
		$dataReader = $query->createCommand()->query();
		$modules = [];
		while ($module = $dataReader->readColumn(0)) {
			if (\App\Privilege::isPermitted($module)) {
				$modules[$module] = \App\Language::translate($module, $module);
			}
		}
		return $modules;
	}
}
