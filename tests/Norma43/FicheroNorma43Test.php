<?php

namespace Test\Norma43;

use Norma43\FicheroNorma43;
use Norma43\Exception\FileNotFoundException;

class FicheroNorma43Test extends \PHPUnit_Framework_TestCase
{
    private $norma43;

    public function setUp()
    {
         $this->norma43 = new FicheroNorma43(__DIR__.'/Resources/simple-sample');
    }

    public function testInexistentFileThrowsException()
    {
        $this->setExpectedException('Norma43\Exception\FileNotFoundException');
        $norma43 = new FicheroNorma43('foo.txt');
    }

    public function testRegistroCabeceraCuentaIsCreated()
    {
        $this->assertInstanceOf('Norma43\RegistroCabeceraCuenta', $this->norma43->getCabeceraCuenta());
    }

    public function testRegistroPrincipalMovimientosIsCreated()
    {
        $movimientos = $this->norma43->getRegistroPrincipalMovimientos();
        $this->assertInternalType('array',$movimientos);
        $this->assertInstanceOf('Norma43\RegistroPrincipalMovimientos', $movimientos[0]);
    }

    public function testRegistroComplementarioConceptoIsCreated()
    {
        $conceptos = $this->norma43->getRegistroComplementarioConcepto();
        $this->assertInternalType('array',$conceptos);
        $this->assertInstanceOf('Norma43\RegistroComplementarioConcepto', $conceptos[0]);
    }
}
