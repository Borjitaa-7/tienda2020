<?php

require_once CONTROLLER_PATH . "ControladorBD.php";


class Paginador {

    private $limite = 5;
    private $pagina;
    private $consulta;
    private $parametros;
    private $total;
    private $bd;
    private $res;

    public function __construct($consulta, $parametros, $limite) {
        $this->limite = $limite;
        $this->consulta = $consulta;
        $this->parametros = $parametros;
        $this->bd = ControladorBD::getControlador();
        $this->bd->abrirBD();
        $this->res = $this->bd->consultarBD($consulta, $parametros);
        $this->filas=$this->res->fetchAll(PDO::FETCH_OBJ);
        $this->total = count($this->filas);
        $this->bd->cerrarBD();
    }

    public function getDatos($p) {
        $this->pagina = $p;
        $inicio = ( $this->pagina - 1 ) * $this->limite;
        
        if ($inicio < 0) {
            $inicio = 0;
            $this->pagina = 1;
        }

        
        if ($inicio > ($this->total - $this->limite)) {
              $this->pagina = $this->pagina - 1;
        }
        
        $result = new stdclass();
        $result->pagina = $this->pagina;
        $result->limite = $this->limite;
        $result->total = $this->total;
        $result->datos = Array();

        if($inicio>=0){
            $consultar = $this->consulta . ' limit ' . $inicio . ',' . $this->limite;
            $this->bd->abrirBD();
            $this->res = $this->bd->consultarBD($consultar,$this->parametros);
            $respuesta = $this->res->fetchAll(PDO::FETCH_OBJ);

            foreach ($respuesta as $dato) {
                $result->datos[] = $dato;
            }
            
            $this->bd->cerrarBD();
        }

        return $result;
    }

    public function crearLinks($enlaces) {
        $ultimo = ceil($this->total / $this->limite);
        $comienzo = (($this->pagina - $enlaces) > 0) ? $this->pagina - $enlaces : 1;
        $fin = (($this->pagina + $enlaces ) < $ultimo) ? $this->pagina + $enlaces : $ultimo;
        
        $clase = ($this->pagina == 1) ? "" : "";
        $html = '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($comienzo) . '">&laquo;</a></li>';

        if ($comienzo > 1) {
            $html .= '<li><a href="?limit=' . $this->limite . '&page=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $comienzo; $i <= $fin; $i++) {
            $clase = ( $this->pagina == $i ) ? "active" : "";
            $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($fin < $ultimo) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="?limit=' . $this->limite . '&page=' . $ultimo . '">' . $ultimo . '</a></li>';
        }
        
        $clase = ( $this->pagina == $fin ) ? "disabled" : "enabled";                  
        $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($fin) . '">&raquo;</a></li>';
        return $html;
    }

}
