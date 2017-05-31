<?php

namespace InvEO\CoreBundle\Twig;

/**
 * Filtro para imprimir objetos dentro de twig
 *
 * Class CoreTwigExtension
 * @package InvEO\CoreBundle\Twig
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class CoreTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('objectToString', array($this, 'objectToStringFilter')),
        );
    }

    /**
     * Retorna una propiedad especifica del objeto
     *
     * @param $value
     * @return string
     * @throws \Exception
     */
    public function objectToStringFilter($value)
    {
        if (is_object($value) && $value instanceof \DateTime ) {
            $value = $value->format('d-m-Y');
        }

        return $value;
    }
}