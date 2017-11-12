<?php

class RemotedbStegi {

	protected $options;

	public function __construct()
	{
		//remote db
		$db_remote_class = new RemotedbConnection();
		$this->db_remote = $db_remote_class->connect();
	}

	// GET Stegi Hours
	public function getStegiHours($fields = [], $where = '', $group_by = '', $order = '', $limit = '', $as_array = false)
	{
		$query_fields = '*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		if ($where) {
			$where = ' WHERE ' . $where;
		}

		if ($group_by) {
			$group_by = ' GROUP BY ' . $group_by;
		}

		if ($order) {
			$order = ' ORDER BY ' . $order;
		}

		if ($limit) {
			$limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__stegihours ".$where." ".$group_by." ".$order." ".$limit;

		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
	}

	// GET Stegi Hours Join with Team
	public function getStegiHoursTeams($fields = [], $where = '', $order = '', $limit = '', $as_array = false)
	{
		$query_fields = '*';
		if ($fields) {
			$query_fields = implode(',', $fields);
		}

		if ($where) {
			$where = ' WHERE ' . $where;
		}

		if ($order) {
			$order = ' ORDER BY ' . $order;
		}

		if ($limit) {
			$query_limit = ' LIMIT ' . $limit;
		}

		$query = "SELECT ".$query_fields." FROM #__stegihours AS a INNER JOIN #__teams AS t ON a.team_id=t.id ".$where." ".$order." ".$limit;

		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
	}

}