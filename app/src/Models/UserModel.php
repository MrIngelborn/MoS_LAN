<?php
namespace MoS\LAN\Models;

class UserModel extends AbstractModel implements Listable
{
    private const LOGIN_TABLE = 'user_login';
    private const TABLE_PREFIX = 'user_';
    private const INFO_TABLE = 'view_user_info';
    
    public function fetchById($id)
    {
        $infoTable = self::INFO_TABLE;
        $query = "SELECT * FROM $infoTable WHERE id = :id LIMIT 1";
        $params = array(':id' => $id);
        $this->fetchData($query, $params);
    }
    public function fetchList()
    {
        $query = 'SELECT id, username FROM '.self::LOGIN_TABLE;
        $this->fetchData($query, null);
    }
    public function getList()
    {
        $list = array();
        foreach ($this->data as $user) {
            $list[] = array(
                'href' => 'users/'.$user['id'],
                'value' => $user['username']
            );
        }
        return $list;
    }
    public function getListTitle()
    {
        return 'Users';
    }
    public function getListHeader()
    {
        return 'List of users';
    }
    
    public function update($id, array $changed)
    {
	    if (!sizeof($changed)) {
		    // No chaged values
		    return;
	    }
        $infoTable = self::INFO_TABLE;
        
        $query = "SELECT * FROM $infoTable WHERE id = :id";
        $params = array(
		    ':id' => $id
	    );
	    $this->fetchData($query, $params);
	    
	    if(!sizeof($this->data)) {
		    // No user with id
		    return;
	    }
	    // Create a new entry for all values that has not been set before
	    foreach ($this->data[0] as $key => $value) {
		    if (array_key_exists($key, $changed) && $value == null) {
			    // Need to create a new entry for property
			    $query = 'INSERT INTO '.self::TABLE_PREFIX.$key." (user_id, $key) VALUES (:id, :value)";
			    $params = array(
				    ':id' => $id,
				    ':value' => $changed[$key]
			    );
			    $this->fetchData($query, $params);
			    unset($changed[$key]);
		    }
	    }
	    
	    // Update existing properties
	    foreach ($changed as $key => $value) {
		    $query = "UPDATE $infoTable SET $key = :value WHERE id = :id";
		    $params = array(
			    ':id' => $id,
			    ':value' => $value
		    );
		    $this->fetchData($query, $params);
	    }
	   
    }
}




