<?php
class BaseModel extends DB
{
    protected $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }
    // READ ALL IN TABLE
    public function getAll($table, $select = ['*'],$orderBys = [], $limit = [])
    {
        $columns = implode(',',$select);
        
        $orderByString = implode(' ',$orderBys);

        $limitByString = implode(',',$limit);
        if($orderByString)
        {
            
            $sql = "SELECT ${columns} FROM ${table} ORDER BY ${orderByString} LIMIT ${limitByString}";
        }
        else{
            $sql = "SELECT ${columns} FROM ${table} LIMIT ${limitByString}";
        }

        return $this->getByQuery($sql);
       
    }
    public function getNumber($table,  $select = ['*'])
    {
        $columns = implode(',',$select);
        $sql = "SELECT COUNT(${columns}) AS TOTAL_NUMBERS FROM ${table}";
        $array = $this->getFirstByQuery($sql);
        $number = $array['TOTAL_NUMBERS'];
        return $number;

    }
    // READ ONE ROW IN TABLE
    public function findById($table,$id)
    {
        $sql = "SELECT * FROM ${table} WHERE id = ${id} LIMIT 1";
        return $this->getFirstByQuery($sql);
    }

    //CREATE ROW IN TABLE
    public function create($table,$data=[])
    {
        $columns = implode(',', array_keys($data));

        $newValues = array_map(function($value){
            return "'".$value."'";
        },array_values($data));
        $newValues = implode(',', $newValues);

        $sql = "INSERT INTO ${table}(${columns}) VALUES(${newValues})";

        $this->_query($sql);
    }
    // UPDATE ROW IN TABLE
    public function update($table, $id, $data){
        $dataSets = [];
        foreach ($data as $key => $val)
        {
            array_push($dataSets, "${key} = '". $val ."'");
        }

        $dataSetString = implode(',', $dataSets);

        $sql = "UPDATE ${table} SET ${dataSetString} WHERE id =${id}";

        return $this->_query($sql);
    }
    // DELETE ROW IN TABLE
    public function delete($table, $id=[])
    {
        $listId = implode(',', $id);
        $sql = "DELETE FROM ${table} WHERE id IN ( ${listId} )";
        return $this->_query($sql);
    }
    
    //--------------- HANDLE SQL----------------------//
    public function getByQuery($sql)
    {
        $query = $this->_query($sql);
        $data = [];

        while($row = mysqli_fetch_assoc($query))
        {
            array_push($data, $row);
        }

        return $data;

    }
    public function getFirstByQuery($sql)
    {
        $query = $this->_query($sql);
        if($query->num_rows>0)
        {
            return mysqli_fetch_assoc($query);
        }
        return null;
    }
    private function _query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}

?>