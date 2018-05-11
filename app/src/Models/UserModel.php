<?php
namespace MoS\LAN\Models;

class UserModel extends AbstractModel implements Listable
{
    private const USER_TABLE = 'users';
    private const INFO_TABLE = 'user_info';
    
    public function fetchById($id)
    {
        $userTable = self::USER_TABLE;
        $infoTable = self::INFO_TABLE;
        $query = "SELECT * "
                ."FROM $userTable "
                ."LEFT JOIN $infoTable "
                ."ON $userTable.id = $infoTable.user_id "
                ."WHERE id = :id "
                ."LIMIT 1";
        $params = array(':id' => $id);
        $this->fetchData($query, $params);
    }
    public function fetchList()
    {
        $query = 'SELECT id, username FROM '.self::USER_TABLE;
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
}