<?php

class RemotedbTeam {

	protected $options;

	public function __construct()
	{
		//remote db
		$db_remote_class = new RemotedbConnection();
		$this->db_remote = $db_remote_class->connect();
	}

	public function getTeams($fields = [], $count = '', $where = '', $order = '', $as_array = false)
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

		// $query = "SELECT ".$query_fields." FROM #__teams WHERE 1=1 ".$query_where." ".$query_order;
		// //echo str_replace('#__', 'cemyx_', $query);
		// $this->db_remote->setQuery($query);

		// if ($as_array) {
		// 	return $this->db_remote->loadAssocList();
		// } else {
		// 	return $this->db_remote->loadObjectList();
		// }
	}

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