<?php
    class TaskModel extends BaseModel{
        const TABLE  = 'task';
        public $id;
        public $name;
        public $description;
        public $start_date;
        public $finished_date;
        public $status;
        public $due_date;
        public $category_id;

        // public function __construct($id
        // ,$name
        // ,$description
        // ,$start_date
        // ,$finished_date
        // ,$status
        // ,$due_date
        // ,$category_id){
        //    $this->id = $id;
        //    $this->name = $name;
        //    $this->description = $description;
        //    $this->start_date = $start_date;
        //    $this->finished_date = $finished_date;
        //    $this->status = $status;
        //    $this->due_date = $due_date;
        //    $this->category_id = $category_id;
        // }  
        public function getAllTask($select = ['*'],$orderBy = [], $limit = [15]){
            return $this->getAll(self::TABLE,$select,$orderBy,$limit);
        }
        public function getOneTask($id){
            return $this->findById(self::TABLE,$id);
        }
        public function getNumberOfTask(){
            return $this->getNumber(self::TABLE,$select = ['*']);
        }
        public function createOneTask($data){
            $dataIdMax = $this->getAll(self::TABLE,['id'], ['id','desc'],[1]);
            $dataIdMax[0]['id']++;
            $data = array_merge($dataIdMax[0], $data);
            $this->create(self::TABLE,$data);
        }
        public function updateOneTask($id,$data)
        {   
           return $this->update(self::TABLE,$id,$data);
        }
        public function deleteTask($id = [])   
        {
            return $this->delete(self::TABLE, $id);
        }
        public function searchTask($searchValue,$limit = 10)
        {
            $searchValue = "'%".$searchValue."%'";
            $sql = "SELECT * FROM TASK WHERE name LIKE ${searchValue} 
                    OR description LIKE ${searchValue} LIMIT ${limit}";

            return $this->getByQuery($sql);
        }
        public function filter($status)
        {
            if($status=="Done")
            {
                $sql = "SELECT * FROM TASK WHERE status = 'Done'";
                return $this->getByQuery($sql);
            }
            else if($status=="Doing")
            {
                $sql = "SELECT * FROM TASK WHERE status = 'Doing'";
                return $this->getByQuery($sql);
            }
            else{
                $sql = "SELECT * FROM TASK WHERE (status = 'Doing' AND DATEDIFF(due_date, CURDATE()) <= 3)";
                return $this->getByQuery($sql);
            }
            
        }

    }
?>