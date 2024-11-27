<?php
class sisdb {
    private $connection;

    public function __construct() {
        // Create a new connection using mysqli
        $this->connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Function to get a single row
    public function getSingleRow($query, $params = []) {
        $stmt = $this->prepareQuery($query, $params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function print_query($query, $params = []) {
        $stmt = $this->prepareQuery($query, $params);
        $queryString = $query;
        foreach ($params as $param) {
            $param = "'" . $this->connection->real_escape_string($param) . "'";
            $queryString = preg_replace('/\?/', $param, $queryString, 1);
        }
        return $queryString;
    }
    
    // Function to get multiple rows
    public function getMultipleRows($query, $params = []) {
        $stmt = $this->prepareQuery($query, $params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    // Function to create a new record
    public function create($query, $params = []) {        
        $stmt = $this->prepareQuery($query, $params);
        $stmt->execute();
        
        $result = false;
        if (strpos(strtoupper($query), 'INSERT') === 0) {
            // Only return insert_id if the query is an INSERT query
            $result = $stmt->insert_id;
        } else {
            $affected_rows = $stmt->affected_rows;
            $result = $affected_rows > 0;
        }

        // $stmt->close();
        return $result;
    }

    // Function to create a new record with an array of data
    public function createWithArray($tableName, $data, $params = []) {
        $query = "INSERT INTO $tableName (" . implode(", ", array_keys($data)) . ") VALUES (" . str_repeat("?,", count($data) - 1) . "?)";
        $values = array_values($data);
        return $this->create($query, array_merge($values, $params));
    }

    // Function to update a record
    public function update($query, $params = []) {
        return $this->create($query, $params); // Reuse create method as the logic is the same
    }

    // Function to update a record with an array of data
    public function updateWithArray($tableName, $data, $conditions, $params = []) {
        $query = "UPDATE $tableName SET ";
        $setValues = [];
        foreach ($data as $key => $value) {
            $setValues[] = "$key = ?";
        }
        $query .= implode(", ", $setValues);
        $query .= " WHERE " . $conditions;
        $values = array_values($data);
        return $this->update($query, array_merge($values, $params));
    }

    // Function to delete a record
    public function delete($query, $params = []) {
        return $this->create($query, $params); // Reuse create method as the logic is similar
    }

    // Function to delete a record
    public function readyQuery(string $query, array $params = []): string {
        // Replace each '?' placeholder in the query with a quoted and escaped parameter
        foreach ($params as &$param) {
            $param = "'" . $this->connection->real_escape_string($param) . "'";
        }
        unset($param); // Unset reference to the last element to avoid issues in subsequent iterations
        
        // Replace placeholders in the query with the corresponding parameters
        $prepared_query = vsprintf(str_replace('?', '%s', $query), $params);
        
        return $prepared_query;
    }
    
    private function prepareQuery($query, $params = []) {
        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings for simplicity
            $stmt->bind_param($types, ...$params);
        }

        return $stmt;
    }

    public function __destruct() {
        $this->connection->close();
    }
}
?>
