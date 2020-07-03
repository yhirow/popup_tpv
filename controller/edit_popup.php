<?php
/// la clase se debe llamar igual que el archivo
class edit_popup extends fs_controller {

  public $popup;

  public function __construct() {
    /// se crea una entrada 'Mi controlador' dentro del menú 'Mio'
    parent::__construct(__CLASS__, 'Entrada', 'popup', FALSE, FALSE);
  }

  protected function private_core() {
    parent::private_core();
    $this->ppage = $this->page->get('admin_popup');
    $this->popup = FALSE;
    if (isset($_GET['cod'])) {
      $popup = new popup();
      $this->popup = $popup->get($_GET['cod']);
    }

    if(isset($_POST['url'])){
      $this->modificar();
    }

  }

  private function modificar() {
    if ($this->popup) {
      $this->popup->url = $_POST['url'];
      $this->popup->boton = $_POST['boton'];
      if ($this->popup->save()) {
        $this->new_message("Datos guardados correctamente.");
      } else {
        $this->new_error_msg("¡Imposible guardar!");
      }
    }
  }

  public function url() {
    if (!isset($this->popup)) {
      return parent::url();
    } else if ($this->popup) {
      return $this->popup->url();
    }
    return $this->page->url();
  }

}
