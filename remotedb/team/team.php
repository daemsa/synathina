<?php

class RemotedbTeam {

	protected $options;

	public function __construct()
	{
		//remote db
		$db_remote_class = new RemotedbConnection();
		$this->db_remote = $db_remote_class->connect();
	}

	// GET Team
	public function getTeam($fields = [], $where = '', $limit = '', $as_array = false)
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

		$query = "SELECT ".$query_fields." FROM #__teams ".$query_where." ".$query_limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssoc();
		} else {
			return $this->db_remote->loadObject();
		}
	}

	// GET Teams
	public function getTeams($fields = [], $where = '', $order_by = '', $limit = '', $as_array = false)
	{
		$query_fields = '*';
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

		$query = "SELECT ".$query_fields." FROM #__teams ".$where." ".$order_by." ".$limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
	}

	// GET Team JOIN Activities
	public function getTeamActivity($fields = [], $where = '', $limit, $as_array = false)
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

		$query = "SELECT ".$query_fields." FROM #__teams AS t INNER JOIN #__actions AS a ON t.id=a.team_id ".$query_where." ".$query_limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssoc();
		} else {
			return $this->db_remote->loadObject();
		}
	}

	// GET Team JOIN Activities
	public function getTeamActivities($fields = [], $where = '', $limit, $as_array = false)
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

		$query = "SELECT ".$query_fields." FROM #__teams AS t INNER JOIN #__actions AS a ON t.id=a.team_id ".$query_where." ".$query_limit;
		//echo str_replace('#__', 'cemyx_', $query);
		$this->db_remote->setQuery($query);

		if ($as_array) {
			return $this->db_remote->loadAssocList();
		} else {
			return $this->db_remote->loadObjectList();
		}
	}

	//GET Teams Ids with COmma Delimiter
	public function getUserIdsCommaDel($where)
	{
		if ($where) {
			$where = 'AND ' . $where;
		}
		$query = "SELECT user_id FROM #__teams
					WHERE 1=1 ".$where;
		$this->db_remote->setQuery($query);
		$team_user_ids = $this->db_remote->loadAssocList();

		return implode(', ', array_map(function ($entry) {
		  return $entry['user_id'];
		}, $team_user_ids));

	}

}