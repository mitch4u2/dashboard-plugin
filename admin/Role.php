<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/Role
 */

/**
 * CRUD Custom Roles for the users
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/role
 * @author     Mohamed Hajjej <mohamed.hajjej@foursites.nl>
 */

namespace admin;

class Role
{
	/**
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $id    The ID of the role.
	 */
	private $id;
	/**
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The Display Name of the role.
	 */
	private $name = "";
	/**
	 * @since    1.0.0
	 * @access   private
	 * @var      Array    $capabilities    the list of capabilities that a role has.
	 */
	private $capabilities = array();


	public function __construct( $id, $name, $capabilities )
	{
		$this->id = $id;
		$this->name = $name;
		$this->capabilities = $capabilities;
	}

	public function CreateRole()
	{
		return add_role( $this->id, $this->name, $this->capabilities );
	}

	public function ViewRole()
	{
		$role = get_role($this->id);
		 //$roleadmin= getrole('administrator');
		 //$obj_merged = (object) array_merge((array) $roleadmin, (array) $role);
		return json_encode($role, true);
	}

	public function AddCap()
	{
		$role = get_role($this->id);
		foreach( $this->capabilities as &$cap )
		{
			$role->add_cap( $cap );
		}

	}

	public function RemoveCap()
	{
		$role = get_role($this->id);
		foreach( $this->capabilities as &$cap )
		{
			$role->remove_cap( $cap );
		}
	}

	public function RenameRole(){
		//try later
	}

	public function DeleteRole()
	{
		return remove_role( $this->id );
	}

	public function __toString()
	{
		return $this->id;
	}

	public function __destruct()
	{
		unset($this);
	}

}

