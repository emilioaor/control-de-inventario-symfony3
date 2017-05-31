<?php

namespace InvEO\CoreBundle\Model\Icons;

/**
 * Iconos con funcionalidad para acceder desde twig
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class Icon
{
    /** Iconos Bootstrap */
    const ICON_HOME = 'glyphicon glyphicon-home';
    const ICON_PRODUCT = 'glyphicon glyphicon-align-justify';
    const ICON_SEARCH = 'glyphicon glyphicon-search';
    const ICON_EDIT = 'glyphicon glyphicon-edit';
    const ICON_RIGHT = 'glyphicon glyphicon-chevron-right';
    const ICON_SAVE = 'glyphicon glyphicon-floppy-saved';
    const ICON_ADD = 'glyphicon glyphicon-plus';
    const ICON_CANCEL = 'glyphicon glyphicon-remove';
    const ICON_REMOVE = 'glyphicon glyphicon-remove';
    const ICON_CLIENT = 'glyphicon glyphicon-user';
    const ICON_SUPPLIER = 'glyphicon glyphicon-user';
    const ICON_INPUT = 'glyphicon glyphicon-resize-small';
    const ICON_OUTPUT = 'glyphicon glyphicon-resize-full';
    const ICON_VALIDATE = 'glyphicon glyphicon-ok';
    const ICON_EXCLAMATION = 'glyphicon glyphicon-exclamation-sign';

    private $constants;
    private $constantKeys;

    /**
     * Por reflection obtengo la lista de constantes de la clase y las
     * agrega a un array privado a nivel del objeto al momento de instanciarse el objeto
     */
    public function __construct()
    {
        $class = new \ReflectionClass(__CLASS__);
        $this->constants = $class->getConstants();

        $this->constantKeys = array_keys($this->constants);
    }

    /**
     * Al momento de invocarse a la constante, PHP interpreta que debería ser una
     * propiedad pública del objeto y como efectivamente no existe, se llama al método
     * __isset para que nosotros decidamos si existe o no. Lo que hacemos es fijarnos
     * si el nombre de la constante que es invocada existe dentro de nuestro array de
     * constantes descubiertas por reflection
     */
    public function __isset($name)
    {
        return true;
    }

    /**
     * Cuando el método __isset devuelve true, entra al método __get y devuelve
     * el valor de la constante
     */
    public function __get($name)
    {
        if (in_array($name, $this->constantKeys)) {
            return $this->constants[$name];
        }

        throw new \Exception('No existe el icono ' . $name . ' en la clase: ' . __CLASS__);
    }
}