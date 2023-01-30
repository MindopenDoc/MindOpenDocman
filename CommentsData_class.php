<?php
/*
 * Copyright (C) 2000-2021. Stephen Lawrence
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// (C) 2002-2004 Stephen Lawrence Jr., Khoa Nguyen
// Builds file data objects

use Aura\Html\Escaper as e;

if (!defined('CommentsData_class')) {
    define('CommentsData_class', 'true', false);

    /*
          mysql> describe data;
          +-------------------+----------------------+------+-----+---------------------+----------------+
          | id                | int(11) unsigned     |      | PRI | NULL                | auto_increment |
          | name              | text                 |      |     | 0                   |                |
          | od_id             | int(11) unsigned     |      |     | 0                   |                |
          | created_by        | int(11)              |      |     |                     |                |
          | created_date      | datetime             |      |     | 0000-00-00 00:00:00 |                |
          | updated_by        | int(11)              | YES  |     | NULL                |                |
          | updated_date      | varchar(255)         |      |     | NULL                |                |
          +-------------------+----------------------+------+-----+---------------------+----------------+
    */

    class CommentsData extends databaseData
    {
        public $comments_message;
        public $created_by;
        public $created_date;
        public $updated_by;
        public $updated_date;
        public $file_id;
        public $error;
        public $status;
        protected $connection;

        public function __construct($id, $connection)
        {
            $this->field_name = 'realname';
            $this->file_id = $id;
            $this->result_limit = 999;  //EVERY FILE's 999 comments fetch at once;
            $this->tablename = 'user_comments';
            $this->connection = $connection;
            // databaseData::__construct($id, $connection);

            // $this->loadDepthData();
        
        }

        /**
         * Return a boolean whether this file exists
         * @return bool|string
         */
        public function exists()
        {
            $query = "
              SELECT
                *
              FROM
                {$GLOBALS['CONFIG']['db_prefix']}$this->tablename
              WHERE
                od_id = :od_id
            ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute(array(':od_id' => $this->file_id));

            switch ($stmt->rowCount()) {
                case 0: return false;
                    break;
                default:return true;
                    break;
            }
        }

        /**
         * This is a more complex version of base class's loadData.
         * This function loads up all the fields in data table
         */
        public function loadData()
        {
            $query = "
              SELECT
                id,
                name,
                od_id,
                created_by,
                created_date,
                updated_by,
                updated_date
              FROM
                {$GLOBALS['CONFIG']['db_prefix']}$this->tablename
              WHERE
                od_id = :od_id
                ";
            echo "<br> The Query is : $query<br>";
            $stmt = $this->connection->prepare($query);
            $stmt->execute(array(':od_id' => $this->file_id));
            $result = $stmt->fetchAll();
            
            if ($stmt->rowCount() <= $this->result_limit) {
                foreach ($result as $row) {
                    $this->comments_message = $row['name'];
                    $this->file_id = $row['od_id'];
                    $this->created_by = $row['created_by'];
                    $this->created_date = stripslashes($row['created_date']);
                    $this->updated_by = stripslashes($row['updated_by']);
                    $this->updated_date = $row['updated_date'];
                }
            } else {
                $this->error = 'no comments added';
            }
            $this->isLocked = $this->status == -1;
            // return $result;
        }


        public function loadDepthData()
        {
            $query = "
              SELECT
                id,
                name,
                od_id,
                created_by,
                created_date,
                updated_by,
                updated_date
              FROM
                {$GLOBALS['CONFIG']['db_prefix']}$this->tablename
              WHERE
                od_id = :od_id
                ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute(array(':od_id' => $this->file_id));
            $result = $stmt->fetchAll();
            if ($stmt->rowCount() <= $this->result_limit) {
                $return_result = array();
                foreach ($result as $row) {
                    $row['created_by'] = $this->getUserName($row['created_by']);
                    $row['updated_by'] = $this->getUserName($row['updated_by']);
                    array_push($return_result,$row);
                }
                return $return_result;
            } else {
                $this->error = 'no comments added';
            }
            $this->isLocked = $this->status == -1;
            
        }

        /**
         * Update the dynamic values of the file
         */
        public function updateData()
        {
            $query = "
              UPDATE
                {$GLOBALS['CONFIG']['db_prefix']}$this->TABLE_DATA
              SET
                category = :category,
                owner = :owner,
                description = :description,
                comment = :comment,
                status = :status,
                department = :department,
                default_rights = :default_rights,
                Designation = :designation
               WHERE
                id = :id
            ";

            $stmt = $this->connection->prepare($query);
            $stmt->execute(array(
                ':category' => $this->category,
                ':owner' => $this->owner,
                ':description' => $this->description,
                ':comment' => $this->comment,
                ':status' => $this->status,
                ':department' => $this->department,
                ':default_rights' => $this->default_rights,
                ':designation' => $this->designation,
                ':id' => $this->id
            ));
        }

        public function getUserName($id){
            if ($id){
                $user_obj = new User($id,$this->connection);
                return $user_obj->first_name;
            }
            return ;
        }

          
    }
}
