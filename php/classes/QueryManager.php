<?php

require_once 'DB.php';

class QueryManager
{
    private $DBConnection = null;

    public function __construct()
    {
        $this->DBConnection = DB::getInstance()->getConnection();
    }

    /**
     * Generate a SQL WHERE statement to be used in a PDO Prepared Statement
     * 
     * @param array $filters Array containing filters information like ['name', 'separator', 'operator']
     * @return string
     */
    private function generateWhereStmt($filters)
    {
        if (empty($filters)) return '';

        $where_stmt = ' WHERE ';

        foreach ($filters as $filter) {
            $separator = $filter['separator'] || ' AND ';
            $operator = $filter['operator'] || '=';

            $where_stmt .= $filter['name'] . $operator . '?' . $separator;
        }

        return $where_stmt;
    }

    public function fetchData($columns, $filters)
    {
        echo $this->generateWhereStmt($filters);
    }
}
