<?php

namespace Zombie\Database;

use Zombie\Config;
use Zombie\Paginator;

class Model
{
    /**
     * Contain a database connection
     *
     * @var mixed
     */
    private $connection;

    /**
     * Table name
     *
     * @var
     */
    protected static $table;

    /**
     * Fields is which available for db query
     *
     * @var array
     */
    protected $fields = [];

    /**
     * String of query
     *
     * @var
     */
    private $query;

    /**
     * Data for query string
     *
     * @var array
     */
    private $bindings = [];

    /**
     * Model constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = DatabaseManager::make(Config::get('database.default'));
    }

    /**
     * Query to database
     *
     * @param array $select
     * @param string $condition
     * @param array $data
     * @return static
     * @throws \Exception
     */
    public static function query($select = ['*'], $condition = '', $data = [])
    {
        $instance = new static();

        $instance->query = "select " . implode(', ', $select) . " from " . static::$table . ' ' . $condition;

        if ($data)
            $instance->bindings = $data;

        return $instance;
    }

    /**
     * Get first record from database
     *
     * @return mixed
     */
    public function first()
    {
        $this->query .= ' limit 1';

        $query = $this->connection->prepare($this->query);

        $this->bindParams($query, $this->bindings);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get count of records
     *
     * @return mixed
     * @throws \Exception
     */
    public function count()
    {
        $instance = new static();

        $query = $instance->connection->prepare("select count(*) from " . static::$table);

        $this->bindParams($query, $this->bindings);

        $query->execute();

        return $query->fetchColumn();
    }

    /**
     * Generate paginate
     *
     * @param int $items
     * @param int $page
     * @param int $count_of_links
     * @return array
     * @throws \Exception
     */
    public function paginate($items = 3, $page = 1, $count_of_links = 3)
    {
        $page = $page && is_numeric($page) && ($page > 0) ? (int) $page : 1;

        $paginator = new Paginator($items, $page, $count_of_links, $this->count());

        $this->query .= ' limit ' . ($items * ($page - 1)) . ', ' . $items;

        $query = $this->connection->prepare($this->query);

        $this->bindParams($query, $this->bindings);

        $query->execute();

        return [$this->collection($query->fetchAll(\PDO::FETCH_ASSOC)), $paginator->links()];
    }

    /**
     * Get result by query string
     *
     * @return array
     * @throws
     */
    public function get()
    {
        $query = $this->connection->prepare($this->query);

        $this->bindParams($query, $this->bindings);

        $query->execute();

        return $this->collection($query->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * Get all records
     *
     * @return array
     * @throws \Exception
     */
    public static function all()
    {
        $instance = new static();

        $query = $instance->connection->prepare("select * from " . static::$table);
        $query->execute();

        return $instance->collection($query->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * Create record
     *
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public static function create(array $data = [])
    {
        $instance = new static();

        static::acceptedFields($instance->fields, $data);

        $keys = $instance->acceptedFieldsAsString($data);
        $values = $instance->acceptedFieldsAsQueryParams($data);

        foreach($data as &$value)
            $value = htmlspecialchars($value, ENT_HTML5);

        $query = $instance->connection->prepare(
            "insert into " . static::$table . "{$keys} values {$values}"
        );

        if ($query->execute($data))
            return (int) $instance->connection->lastInsertId();
    }

    /**
     * Update record
     *
     * @param string $condition
     * @param array $params
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public static function update($condition = '', $params = [], $data = [])
    {
        $instance = new static();

        static::acceptedFields($instance->fields, $data);

        $query = $instance->connection->prepare(
            "update " . static::$table . " set " . $instance->prepareUpdateFields($data) . $condition
        );

        $merge = array_merge($data, $params);

        foreach($merge as &$value)
            $value = htmlspecialchars($value, ENT_HTML5);

        $query->execute($merge);

        return $query->rowCount();
    }

    /**
     * Generate parameters string for update query
     *
     * @param $data
     * @return string
     */
    private function prepareUpdateFields($data)
    {
        $query = '';

        foreach($data as $key => $value) {
            if ($key === array_key_last($data))
                $query .= $key . '=' . ':' . $key . ' ';
            else
                $query .= $key . '=' . ':' . $key . ',';
        }

        return $query;
    }

    /**
     * Bind parameters by name
     *
     * @param $query
     * @param $data
     */
    private static function bindParamsByName(&$query, $data)
    {
        foreach($data as $key => $value)
            $query->bindParam((':' . $key), $value);
    }

    /**
     * Bind parameters by index
     *
     * @param $query
     * @param $data
     */
    private static function bindParams(&$query, $data)
    {
        for($i = 0; $i < count($data); $i++)
            $query->bindParam(($i + 1), $data[$i]);
    }

    /**
     * Check available fields for operation
     *
     * @param $fields
     * @param array $data
     * @throws \Exception
     */
    private static function acceptedFields($fields, array $data = [])
    {
        foreach($data as $key => $field)
            if (!in_array($key, $fields))
                throw new \Exception("Parameter [{$key}] is have not access to this operation");
    }

    /**
     * Generate string for create operation
     *
     * @param array $fields
     * @return string
     */
    private function acceptedFieldsAsString(array $fields)
    {
        $string = ' (';

        foreach($fields as $name => $value) {
            if ($name === array_key_last($fields))
                $string .= $name;
            else
                $string .= $name . ',';
        }

        return $string . ') ';
    }

    /**
     * Generate string for binding parameters
     *
     * @param array $fields
     * @return string
     */
    private function acceptedFieldsAsQueryParams(array $fields)
    {
        $string = ' (';

        foreach($fields as $name => $value) {
            if ($name === array_key_last($fields))
                $string .= ':' . $name;
            else
                $string .= ':' . $name . ', ';
        }

        return $string . ') ';
    }

    /**
     * Wrap result to collection
     *
     * @param $array
     * @return array
     * @throws \Exception
     */
    private function collection($array)
    {
        $collect = [];

        foreach($array as $row) {
            $tmp = new static;

            foreach($row as $key => $item)
                $tmp->{$key} = $item;

            array_push($collect, $tmp);
        }

        return $collect;
    }
}