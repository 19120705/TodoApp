<?php
    class CategoryModel extends BaseModel{
        const TABLE = 'category';
        public $name;
        public $date_created;
        public function getAllCategory($select = ['*'],$orderBy = [], $limit = [15]){
            return $this->getAll(self::TABLE,$select,$orderBy,$limit);
        }
        public function getId($name){
            $name = "'%".$name."%'";
            $sql = "SELECT id FROM CATEGORY WHERE name LIKE ${name} LIMIT 1";
            return $this->getFirstByQuery($sql);
        }
        public function getOneCategory($id){
            return $this->findById(self::TABLE,$id);
        }
        public function createOneCategory($data){
            $dataIdMax = $this->getAll(self::TABLE,['id'], ['id','desc'],[1]);
            $dataIdMax[0]['id']++;
            $data = array_merge($dataIdMax[0], $data);
            $this->create(self::TABLE,$data);
        }
        public function updateOneCategory($id,$data)
        {   
           $this->update(self::TABLE,$id,$data);
        }
        public function deleteOneCategory($id)   
        {
            $this->delete(self::TABLE, $id);
        }
    }
?>