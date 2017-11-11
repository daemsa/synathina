<?php

class RemotedbActivity {

	protected $options;

	public function __construct()
	{
		//remote db
		$db_remote_class = new RemotedbConnection();
		$this->db_remote = $db_remote_class->connect();
	}

	public function getActivities($fields = [], $count = '', $where = '', $order = '')
	{
		// $query_fields = '*';
		// if ($count) {
		// 	$query_fields = 'COUNT('.$count.')';
		// } elseif ($fields) {
		// 	$query_fields = implode(',', $fields);
		// }

		// $query_where = '';
		// if ($where) {
		// 	$query_where = 'AND ' . $where;
		// }

		// $query_order = '';
		// if ($order) {
		// 	$query_order = $order;
		// }

		// $query = "SELECT ".$query_fields." FROM #__actions WHERE 1=1 ".$query_where." ".$query_order;

		// $this->db_remote->setQuery($query);

		// return $this->db_remote->loadObjectList();
	}

	public function getActivitiesJoin($fields = [], $count = '', $where = '', $order = '')
	{
		// $query_fields = 'a.ID';
		// if ($count) {
		// 	$query_fields = 'COUNT('.$count.')';
		// } elseif ($fields) {
		// 	$query_fields = implode(',', $fields);
		// }

		// $query_where = '';
		// if ($where) {
		// 	$query_where = $where;
		// }

		// $query_order = '';
		// if ($order) {
		// 	$query_order = $order;
		// }

		// $query = "SELECT ".$query_fields." FROM #__actions AS a INNER JOIN #__actions AS aa ON a.id = aa.action_id WHERE 1=1 AND ".$query_where." ".$query_order;

		// $this->db_remote->setQuery($query);
		// //echo str_replace('#__', 'cemyx_', $query);
		// if ($count) {
		// 	return $this->db_remote->loadResult();
		// } else {
		// 	return $this->db_remote->loadObjectList();
		// }
	}

	public function getActivitiesCount($where = '', $group_by = '') {
		if ($where) {
			$where = ' WHERE ' . $where;
		}
		$query = "SELECT COUNT(aa.id) FROM #__actions AS a
					INNER JOIN #__actions AS aa ON aa.action_id=a.id
					".$where." ".$group_by." ";
		$this->db_remote->setQuery($query);

		return $this->db_remote->loadResult();
	}

	public function getActivitiesTeams($fields, $where = '', $group_by = '', $order_by = '') {
		$query_fields = 'a.ID';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}
		if ($where) {
			$where = 'WHERE ' . $where;
		}
		$query = "SELECT ".$query_fields." FROM #__actions AS a
					INNER JOIN #__actions AS aa ON aa.action_id=a.id
					INNER JOIN #__teams AS t ON t.id=a.team_id
					".$where." ".$group_by." ".$order_by." ";
		$this->db_remote->setQuery($query);

		return $this->db_remote->loadObjectList();
	}

}