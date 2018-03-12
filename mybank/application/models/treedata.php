<?php
	class Treedata extends Model{

		function __construct(){
			parent::Model();
			$this->load->database();
		}


		function getTree(){
			$result = array();
			$query = $this->db->get("user_group")->result_array();
			for($i = 0,$len = count($query);$i < $len;$i++){
				$result[$i][0]= $query[$i]['GroupID'];
				$result[$i][1]= $query[$i]['ParentID'];
				$result[$i][2]= $query[$i]['GroupName'];
			}

			$userarray = $this->getUserList();
			return array_merge($result,$userarray);
		}


		/**
		 * 得到用户列表并以二维数组的形式展示
		 * @return Array $result 包含用户数据的数组
		 */
		function getUserList(){
			$result = array();
			$query = $this->db->get("user_data")->result_array();
			for($i = 0,$len = count($query);$i < $len;$i++){
				$result[$i][0] = 'user'.$query[$i]['UserID'];
				$result[$i][1] = $query[$i]['UserGroupID'];
				$result[$i][2] = $query[$i]['UserName'];
			}
			return $result;
		}
	}
?>