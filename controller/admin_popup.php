<?php
require_once 'plugins/facturacion_base/extras/fbase_controller.php';
/// la clase se debe llamar igual que el archivo
class admin_popup extends fbase_controller {

  public $popup;
  public $resultados;
  public $offset;
  public $total_resultados;

  public function __construct() {
    /// se crea una entrada 'Mi controlador' dentro del menú 'Mio'
    parent::__construct(__CLASS__, 'POPUP', 'admin');
  }

  protected function private_core() {
    parent::private_core();
    $this->popup = new popup();
    $this->texto = 'Ventana Emergente TPV';
        $this->texto2 = '<h3>En este plugin se añade un boton en la pantalla de TVP para poder ingresar a otra web desde la misma pantalla, se puede tener para avisos o para ingresar al portal de su proveedor de recargas electronicas</h3></br>
<h4>Se agregan accesos rapidos para acceder a los botones de la misma pantalla sin usar el mouse</h4>';
        $this->lista = array('REIMPRIMIR TICKET', 'ABRIR CAJON', 'CERRAR CAJA', 'GUARDAR...');

    if (isset($_POST['surl'])){
      $this->nuevo_popup();
    }else if (isset($_GET['delete'])){
      $this->eliminar_popup();
    }

    $this->ini_filters();
    $this->buscar();
  }

  private function ini_filters() {
    $this->offset = 0;
    if (isset($_GET['offset'])) {
      $this->offset = intval($_GET['offset']);
    }
  }

  private function nuevo_popup(){
    $popup0= new popup();
    $popup0->idpopup = $popup0->get_new_codigo();
    $popup0->url = $_POST['surl'];
    $popup0->boton = $_POST['sboton'];
    if ($popup0->save()) {
      $this->new_message("Entrada " . $age0->codagente . " guardada correctamente.");
      header('location: ' . $popup0->url());
    } else {
      $this->new_error_msg("¡Imposible guardar la entrada!");
    }
  }

  private function eliminar_popup(){
    $popup0 = $this->popup->get($_GET['delete']);
    if ($popup0) {
      if ($popup0->delete()) {
        $this->new_message("Entrada " . $popup0->idpopup . " eliminada correctamente.");
      } else {
        $this->new_error_msg("¡Imposible eliminar la entrada!");
      }
    } else {
      $this->new_error_msg("¡Entrada no encontrado!");
    }
  }

  public function paginas() {
      $url = $this->url() . "&query=" . $this->query;
      return $this->fbase_paginas($url, $this->total_resultados, $this->offset);
  }

  private function buscar() {
    $this->total_resultados = 0;
    $query = $this->query;

    $data = $this->db->select("SELECT COUNT(idpopup) as total FROM popup WHERE URL LIKE '%" . $query . "%'");
    if ($data) {
      $this->total_resultados = intval($data[0]['total']);
    }

    $data2 = $this->db->select("SELECT * FROM popup WHERE URL LIKE '%" . $query . "%'");
    if ($data2) {
      foreach ($data2 as $d) {
        $this->resultados[] = new popup($d);
      }
    }
  }

 }
