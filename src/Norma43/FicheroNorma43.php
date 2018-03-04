<?php

namespace Norma43;

use Norma43\Exception\FileNotFoundException;

class FicheroNorma43
{
    /**
     * Registro de Cabecera de Cuenta
     * @var RegistroCabeceraCuenta
     */
    private $cabeceraCuenta;

    /**
     * Registro Principal de Movimientos
     * @var Array <RegistroPrincipalMovimientos>
     */
    private $registroPrincipalMovimientos;

    /**
     * Array de registros complementarios de concepto
     * @var Array<RegistroComplementarioConcepto>
     */
    private $registrosComplementarios;

    /**
     * Registro final de cuenta
     * @var RegistroFinalCuenta
     */
    private $registroFinalCuenta;

    /**
     * Registro de fin de fichero
     * @var RegistroFinFichero
     */
    private $registroFinFichero;


    public function __construct($path = null)
    {
        $this->registroPrincipalMovimientos = array();
        $this->registrosComplementarios = array();

        if(null != $path) {
            $this->load($path);
        }

        return $this;
    }

    public function load($path)
    {
        $fd = @fopen($path, 'r');

        if(!$fd) {
            throw new FileNotFoundException("File not found", 100);
        }

        while(!feof($fd)) {
            $linea = fgets($fd);
            $tipo = substr($linea, 0, 2);

            switch($tipo) {
                case Registro::REGISTRO_CABECERA_CUENTA:
                    $this->cabeceraCuenta = new RegistroCabeceraCuenta($linea);
                    break;
                case Registro::REGISTRO_PRINCIPAL_MOVIMIENTOS:
                    $this->registroPrincipalMovimientos[] = new RegistroPrincipalMovimientos($linea);
                    break;
                case Registro::REGISTRO_COMPLEMENTARIO_CONCEPTO:
                    $this->registrosComplementarios[] = new RegistroComplementarioConcepto($linea);
                    break;
                case Registro::REGISTRO_COMPLEMENTARIO_INFORMACION:
                    break;
                case Registro::REGISTRO_FINAL_CUENTA:
                    break;
                case Registro::REGISTRO_FIN_FICHERO:
                    break;
            }
        }
    }


    /**
     * @return \Norma43\RegistroCabeceraCuenta
     */
    public function getCabeceraCuenta()
    {
        return $this->cabeceraCuenta;
    }

    /**
     * @return RegistroPrincipalMovimientos[]
     */
    public function getRegistroPrincipalMovimientos()
    {
        return $this->registroPrincipalMovimientos;
    }

    /**
     * @return RegistroPrincipalMovimientos[]
     */
    public function getRegistroComplementarioConcepto()
    {
        return $this->registrosComplementarios;
    }
}
