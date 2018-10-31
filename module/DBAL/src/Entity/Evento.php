<?php

namespace DBAL\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Evento
 *
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="EVENTO")
 */
class Evento {
    //put your code here

    /**
     * @ORM\Id
     * @ORM\Column(name="ID_EVENTO", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="FECHA_EVE", type="datetime")
     */
    protected $fecha;

    /**
     * Many Eventos have One TipoEvento.
     * @ORM\ManyToOne(targetEntity="TipoEvento")
     * @ORM\JoinColumn(name="TIPO_EVE", referencedColumnName="ID_EVENTO")
     */
    protected $tipo;

    /**
     * Many Eventos have One Cliente.
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="CLIENTE", referencedColumnName="ID_CLIENTE")
     */
    protected $cliente;

    /**
     * Many Eventos have One Ejecutivo.
     * @ORM\ManyToOne(targetEntity="Ejecutivo")
     * @ORM\JoinColumn(name="EJECUTIVO", referencedColumnName="ID_EJECUTIVO")
     */
    protected $ejecutivo;

    /**
     * @ORM\Column(name="DESCRIPCION", nullable=true, type="string")
     */
    protected $descripcion;
    protected $nombre_cliente;
    protected $apellido_cliente;
    protected $usuario_ejecutivo;

    public function __construct() {
        $cliente = $this->cliente;
        if (!is_null($cliente)) {
            $this->nombre_cliente = $cliente->getNombre();
            $this->apellido_cliente = $cliente->getApellido();
        } else {
            $this->nombre_cliente = "NO DEFINIDO";
            $this->apellido_cliente = "NO DEFINIDO";
        }

        $ejecutivo = $this->ejecutivo;
        if (!is_null($ejecutivo)) {
            $this->usuario_ejecutivo = $ejecutivo->getUsuario();
        } else {
            $this->usuario_ejecutivo = "NO DEFINIDO";
        }
    }

    function getId() {
        return $this->id;
    }

    function getFecha() {

        return $this->fecha;
    }

    function getTipo() {
        return $this->tipo->getNombre();
    }

    function getTipoId() {
        return $this->tipo->getId();
    }

    function getId_cliente() {
        return $this->cliente;
    }

    function getId_ejecutivo() {
        return $this->ejecutivo;
    }

    function setId($id_evento) {
        $this->id_evento = $id_evento;
    }

    function setFecha($fecha_evento) {
        $this->fecha = $fecha_evento;
    }

    function setTipo($tipo_evento) {
        $this->tipo = $tipo_evento;
    }

    function setId_cliente($id_cliente) {
        $this->cliente = $id_cliente;
    }

    function setId_ejecutivo($id_ejecutivo) {
        $this->ejecutivo = $id_ejecutivo;
    }

    public function getNombreCliente() {

        if (is_null($this->cliente)) {
            return "NO DEFINIDO";
        } else {
            $nombre = $this->cliente->getNombre();
            $apellido = $this->cliente->getApellido();
            $nya = $nombre . " " . $apellido;
            return $nya;
        }
    }

    public function getUsuarioEjecutivo() {

        if (is_null($this->ejecutivo)) {
            return "NO DEFINIDO";
        } else {
            return $this->ejecutivo->getUsuario();
        }
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}
