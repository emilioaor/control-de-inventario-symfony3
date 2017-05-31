<?php

namespace InvEO\CoreBundle\Repository;

/**
 * Base para todos los repositorios
 * Class BaseRepository
 * @package InvEO\CoreBundle\Repository
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
abstract class BaseRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Se debe sobreescribir en cada repositorio y retornar una entidad
     * con los valores por defecto para el registro
     * @return mixed
     */
    abstract function getDefaultEntity();

    /**
     * Genera un codigo para el nuevo registro. La mascara debe cumplir
     * con el siguiente formato
     *
     * {TEST} //3 o 4 Caracteres en mayuscula encerrados entre llaves {}
     * {0000} // Seguido de 3 a 7 "0" entre llaves {} que indicaran la cantidad de caracteres numericos
     *
     * Ejemplos : {TEST}{000000}
     *           {TES}{000}
     *           {OTRO}{0000000}
     *
     * @param string $mask
     * @return string
     * @throws \Exception
     */
    public function generateCode($mask = '{PROV}{0000000}')
    {
        if (preg_match('/^\{[A-Z]{3,4}\}\{[0]{3,7}\}$/', $mask)) {

            //TODO(EO) Se puede hacer esta logica con un filtro por expresion regular o algo como eso. Probar
            $pos = strpos($mask, '}'); //Obtener fin de la primera parte de la mascara
            $text = substr($mask, 1, $pos - 1); //Obtener texto de la mascara sin las {}
            $number = substr($mask, $pos + 2, -1); //Obtiene los caracteres numericos sin las {}

            $lentNumber = strlen($number); //Cantidad de caracteres numericos

            //Comprobar si existen registros con la misma mascara para generar el consecutivo
            $results = $this->createQueryBuilder('p')
                ->select('p')
                ->where('p.mask = :mask')->setParameter('mask', $mask)
                ->getQuery()->getResult()
            ;

            $count = count($results);

            $nextNumber = $count + 1; //Obtener el siguiente codigo
            $lenNextNumber = strlen($nextNumber); //Comprobar la longitud del nuevo numero

            while ($lenNextNumber < $lentNumber) {
                //Se agregan 0 a la izquierda hasta alcanzar la longitud de la mascara
                $nextNumber = '0' . $nextNumber;
                $lenNextNumber = strlen($nextNumber);
            }

            $code = $text . $nextNumber;

            return $code;
        }

        throw new \Exception("La mascara no cumple con el formato correcto");
    }
}
