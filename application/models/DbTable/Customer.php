<?php

class Application_Model_DbTable_Customer extends Zend_Db_Table_Abstract {

    protected $_name = 'customer';
    
  

    public function gravar($data) {
        return $this->insert($data);
    }

    public function editar($data, $id) {



        return $this->update($data, 'id=' . $id . '');
    }

    public function listar() {
        $select = $this->select()
                ->order("id asc");
        return $this->fetchall($select)->toArray();
    }

    public function buscar($id, $name, $option1, $option2) {
        if (!$id) {
            $id= 'NULL';
        }
       
        if (!$name) {
            $name = 'NULL';
        }



       // echo $id;
       // echo "<br>";
       // echo $name;
      //  echo "<br>";
      //  echo $opt1;
      //  echo "<br>";
      //  echo $opt2;
      //  echo "<br>";
     //   echo $opt3;

        $select = $this->select()
                ->from(array('customer'),array('id AS paciente','name','convenio'))

                ->Where('id=?', $id)
                
                ->orWhere("name LIKE '%$name%'")
                ->group('id')
             
                ->setIntegrityCheck(false); // ADD This Line

        
        
        
        
        return $this->fetchAll($select)->toArray();
    }

    public function deletar($id) {

        return $this->delete('id='. $id .'');
    }
    
      public function searchPayment($id) {
        if (!$id) {
            $id= 'NULL';
        }   
        $select = $this->select()
                ->Where('id=?', $id);
                

        return $this->fetchAll($select)->toArray();    
        
    }
      


}
