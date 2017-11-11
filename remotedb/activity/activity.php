<?php

class RemotedbActivity {

	protected $options;

	public function __construct()
	{
		//remote db
		$db_remote_class = new RemotedbConnection();
		$this->db_remote = $db_remote_class->connect();
	}

	// GET Activity
	public function getActivity($fields = [], $where = '', $limit = '', $as_array = false)
	{
		$query_fields = '*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		$query_where = '';
		if ($where) {
			$query_where = ' WHERE ' . $where;
		}

		$query_limit = '';
		if ($limit) {
			$query_limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__actions ".$query_where." ".$query_limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssoc();
		} else {
			return $this->db_remote->loadObject();
		}
	}

	// GET Activities
	public function getActivities($fields = [], $where = '', $order = '', $limit = '', $as_array = false)
	{
		$query_fields = '*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		$query_where = '';
		if ($where) {
			$query_where = ' WHERE ' . $where;
		}

		$query_order = '';
		if ($order) {
			$query_order = ' ORDER BY ' . $order;
		}

		$query_limit = '';
		if ($limit) {
			$query_limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__actions ".$query_where." ".$query_order." ".$query_limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
	}

	// GET Activity JOIN Team
	public function getActivityTeam($fields = [], $where = '', $limit = '', $as_array = false)
	{
		$query_fields = 'a.*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		if ($where) {
			$where = ' WHERE ' . $where;
		}

		if ($limit) {
			$limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__actions AS a INNER JOIN #__teams AS t ON a.team_id=t.id ".$where." ".$limit;

		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssoc();
		} else {
			return $this->db_remote->loadObject();
		}
	}

	// GET Activities JOIN Team
	public function getActivitiesTeam($fields = [], $where = '', $order_by = '', $limit = '', $as_array = false)
	{
		$query_fields = 'a.*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		if ($where) {
			$where = ' WHERE ' . $where;
		}

		if ($order_by) {
			$order_by = ' ORDER BY ' . $order_by;
		}

		if ($limit) {
			$limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__actions AS a INNER JOIN #__teams AS t ON a.team_id=t.id ".$where." ".$order_by." ".$limit;

		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
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

	public function getActivitiesTeams($fields, $where = '', $group_by = '', $order_by = '', $limit = '') {

		$query_fields = 'a.ID';

		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		if ($where) {
			$where = 'WHERE ' . $where;
		}

		if ($group_by) {
			$group_by = 'GROUP BY ' . $group_by;
		}

		if ($order_by) {
			$order_by = 'ORDER BY ' . $order_by;
		}

		if ($limit) {
			$limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__actions AS a
					INNER JOIN #__actions AS aa ON aa.action_id=a.id
					INNER JOIN #__teams AS t ON t.id=a.team_id
					".$where." ".$group_by." ".$order_by." ".$limit." ";
		$this->db_remote->setQuery($query);

		return $this->db_remote->loadObjectList();
	}

}