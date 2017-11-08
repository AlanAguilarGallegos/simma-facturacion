<?php
class Sucursales extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index($idempresa=0)
	{
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAll();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		$body=$this->load->view('sucursales/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa)
	{
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->modempresa->getFromDatabase($idempresa);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('sucursales/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modsucursal,
			"empresa"=>$this->modempresa
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modsucursal');
		$this->load->model('modresiduo');
		$this->modsucursal->getFromInput();
		$this->modsucursal->addToDatabase();
		$id=$this->modsucursal->getIdsucursal();
		$this->modsesion->addLog(
			"agregar",
			$this->modsucursal->getIdsucursal(),
			$this->modsucursal->getNombre(),
			"sucursal",
			"relempsuc"
			);
		$this->modresiduo->set(0,'Cultivos y Cepas','BI1',0,0,0,0,0,1,1,$id,98);
		$this->modresiduo->addToDatabase();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
		$this->modresiduo->set(0,'Objetos Punzocortantes','BI2',0,0,0,0,0,1,1,$id,98);
		$this->modresiduo->addToDatabase();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
		$this->modresiduo->set(0,'Patológicos','BI3',0,0,0,0,0,1,1,$id,98);
		$this->modresiduo->addToDatabase();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
		$this->modresiduo->set(0,'No Anatónmicos','BI4',0,0,0,0,0,1,1,$id,98);
		$this->modresiduo->addToDatabase();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
		$this->modresiduo->set(0,'Sangre','BI5',0,0,0,0,0,1,1,$id,98);
		$this->modresiduo->addToDatabase();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
		echo $id;
	}
	public function ver($id)
	{
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
		$this->load->model('modruta');
		$this->modsucursal->getFromDatabase($id);
		$this->modempresa->getFromDatabase($this->modsucursal->getIdempresa());
		$operadores=array();
		$vehiculos=array();
		$rutas=array();
		//if($this->modempresa->getCoorporativo()==1)
		if($this->modempresa->getTransportista()==1)
		{
			$operadores=$this->modoperador->getAll($id);
			$vehiculos=$this->modvehiculo->getAll($id);
			$rutas=$this->modruta->getAll($id);
			$operadores=($operadores===false?array():$operadores);
			$vehiculos=($vehiculos===false?array():$vehiculos);
			$rutas=($rutas===false?array():$rutas);
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('sucursales/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modsucursal,
			"operadores"=>$operadores,
			"vehiculos"=>$vehiculos,
			"rutas"=>$rutas
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modsucursal->getIdsucursal(),
			$this->modsucursal->getNombre(),
			"",
			""
			);
	}
	public function actualizar($id)
	{
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->modsucursal->getFromDatabase($id);
		$this->modempresa->getFromDatabase($this->modsucursal->getIdEmpresa());
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('sucursales/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modsucursal,
			"empresa"=>$this->modempresa
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function update()
	{
		$this->load->model('modsucursal');
		$this->modsucursal->getFromInput();
		$this->modsucursal->updateToDatabase();
		echo $this->modsucursal->getIdsucursal();
		$this->modsesion->addLog(
			"actualizar",
			$this->modsucursal->getIdsucursal(),
			$this->modsucursal->getNombre(),
			"sucursal",
			""
			);
	}
	public function eliminar($id)
	{
		$this->load->model('modsucursal');
		$this->load->model('modruta');
		$this->load->model('modvehiculo');
		$this->load->model('modoperador');
		$this->load->model('modcliente');
		$this->load->model('modresiduo');
		$this->load->model('modgenerador');
		$this->modsucursal->getFromDatabase($id);
		$this->modsucursal->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modsucursal->getIdsucursal(),
			$this->modsucursal->getNombre(),
			"sucursal",
			"relempsuc,relrutveh,relsucveh,vehiculo,relbitrut,relmanrut,relrutgen,relsucrut,relrutope,ruta,relsucope,operador,relsuccli,relcligen,cliente,relgenman,generador,relsucres,residuo"
			);
	}
}
?>