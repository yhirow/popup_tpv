<?php

/// la clase se debe llamar igual que el archivo
class popup extends fs_model {
  public $idpopup;
  public $url;
  public $boton;

  public function __construct($data = FALSE) {
    parent::__construct('popup'); /// aquí indicamos el NOMBRE DE LA TABLA
    if($data) {
       $this->idpopup = $data['idpopup'];
       $this->url = $data['url'];
       $this->boton = $data['boton'];       
    }else{
       $this->idpopup = null;
       $this->url = null;       
       $this->boton = null;      
    }
  }

  public function get_new_codigo(){
   $sql = "SELECT MAX(" . $this->db->sql_to_int('idpopup') . ") as cod FROM " . $this->table_name . ";";
   $data = $this->db->select($sql);
   if ($data) {
     return (string) (1 + (int) $data[0]['cod']);
   }
   return '1';
  }

  public function url() {
   if (is_null($this->idpopup)) {
     return "index.php?page=admin_popup";
   }
   return "index.php?page=edit_popup&cod=" . $this->idpopup;
  }

  public function get($cod) {
    $data = $this->db->select("SELECT * FROM " . $this->table_name . " WHERE idpopup = " . $this->var2str($cod) . ";");
    if ($data) {
      return new \popup($data[0]);
    }
    return FALSE;
  }

  public function exists() {
    if(is_null($this->idpopup)) {
       return FALSE;
    }else{
       return $this->db->select("SELECT * FROM ".$this->table_name." WHERE idpopup = ".$this->var2str($this->idpopup).";");
    }
  }

  public function save() {
    if ($this->exists()){
      $sql = "UPDATE " . $this->table_name . " SET url = " . $this->var2str($this->url) .
        ", boton = " . $this->var2str($this->boton) .        
        " WHERE idpopup = " . $this->idpopup . ";";
    }else{
      $sql = "INSERT INTO " . $this->table_name . " (idpopup,url, boton) VALUES
      (" . $this->var2str($this->idpopup) .
      "," . $this->var2str($this->url) .
      "," . $this->var2str($this->boton) .");";
    }
    return $this->db->exec($sql);
  }

  public function delete() {
    return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE idpopup = " . $this->var2str($this->idpopup) . ";");
  }

  public function all() {
    $data = $this->db->select("SELECT * FROM " . $this->table_name . " ORDER BY idpopup ASC;");
    if ($data) {
      foreach ($data as $p) {
        $listak[] = new \popup($p);
      }
    }
   return $listak;
  }

}
