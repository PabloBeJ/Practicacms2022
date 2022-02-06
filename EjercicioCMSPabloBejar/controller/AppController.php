<?php
namespace App\Controller;
use App\Model\Tenista;
use App\Helper\ViewHelper;
use App\Helper\DbHelper;
class AppController
{
    var $db;
    var $view;
    function __construct()
    {
        //Conexión a la BBDD
        $dbHelper = new DbHelper();
        $this->db = $dbHelper->db;

        //Instancio el ViewHelper
        $viewHelper = new ViewHelper();
        $this->view = $viewHelper;
    }
    public function index(){

        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM tenistas WHERE activo=1 AND home=1 ORDER BY fecha DESC");

        //Asigno resultados a un array de instancias del modelo
        $tenistas = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($tenistas,new Tenista($row));
        }

        //Llamo a la vista
        $this->view->vista("app", "index", $tenistas);
    }

    public function acercade(){

        //Llamo a la vista
        $this->view->vista("app", "acerca-de");
    }
    public function tenistas(){

        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM tenistas WHERE activo=1 ORDER BY fecha DESC");

        //Asigno resultados a un array de instancias del modelo
        $tenistas = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($tenistas,new Tenista($row));
        }

        //Llamo a la vista
        $this->view->vista("app", "tenistas", $tenistas);

    }

    public function tenista($slug){

        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM tenistas WHERE activo=1 AND slug='$slug' LIMIT 1");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $tenista= new Tenista($row);

        //Llamo a la vista
        $this->view->vista("app", "tenista", $tenista);

    }
}