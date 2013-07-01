<?php

class User_Access extends Doctrine_Record 
{
	public function setTableDefinition() 
	{
		$this -> hasColumn('User_Group', 'varchar', 10);
		$this -> hasColumn('Menu', 'varchar', 10);
	}

	public function setUp() 
	{
		$this -> setTableName('user_access');
		$this -> hasOne('Menus as Menus', array('local' => 'Menu', 'foreign' => 'id'));
	}

	public static function getAccessRights($user_group) 
	{
		//gets the menus that a user can access from the database
		$query = Doctrine_Query::create() -> select("*") -> from("User_Access") -> where("User_Group = '" . $user_group . "'");
		$rights = $query -> execute();
		return $rights;
	}

}
