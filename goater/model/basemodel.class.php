<?php

abstract class basemodel {

    public $data; //Tableau associatif global

    function __construct($array = null){ //Constructeur avec argument facultatif
        if(is_array($array)){ // Verification du tableau
            foreach($array as $key => &$value){ // Parcours du tableau
                 __set($key, $value);    // Attribution des valeurs du tableau
            }
        }
    }

    function __set($attribute,$value){  // Fonction magique pour le remplissage du tableau associatif
        $this->data[$attribute] = $value;
    }

    function __get($attribute){ // Fonction qui récupère la $value en fonction d'un $attribute
        return $this->data[$attribute];
    }

    public function save(){
        $connection = new dbconnection() ;
        if($this->id){
          $sql = "update jabaianb.".get_class($this)." set " ;

          $set = array() ;
          foreach($this->data as $att => $value)
            if($att != 'id' && $value)
              $set[] = "$att = '".$value."'" ;

          $sql .= implode(",",$set) ;
          $sql .= " where id=".$this->id ;
        }
        else{
          $sql = "insert into jabaianb.".get_class($this)." " ;
          $sql .= "(".implode(",",array_keys($this->data)).") " ;
          $sql .= "values ('".implode("','",array_values($this->data))."')" ;
        }
        $resultat = $connection->doExec($sql) ;
        $id = $connection->getLastInsertId("jabaianb.".get_class($this)) ;

        return $id == false ? NULL : $id ;
  }
}
