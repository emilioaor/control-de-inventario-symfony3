<?php
namespace InvEO\CoreBundle\Model\Alert;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * !-- Alertas del sistema --!
 * Tengo pensado inyectar el servicio dentro de las variables
 * globales de twig para mostrar mensajes de alerta en el sistema
 *
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class Alert
{
    /** Tipos de alertas */
    const ALERT_SUCCESS = 'alert-success';
    const ALERT_FAIL = 'alert-danger';

    /** Mensajes de alertas */
    const ALERT_REGISTER_SUCCESS = 'Registro completo';
    const ALERT_REGISTER_FAIL = 'Error al registrar';
    const ALERT_UPDATE_SUCCESS = 'Registro actualizado';
    const ALERT_UPDATE_FAIL = 'Error al actualizar';
    const ALERT_DELETE_SUCCESS = 'Registro eliminado';
    const ALERT_DELETE_FAIL = 'Error al eliminar';
    const ALERT_VALIDATE_SUCCESS = 'Validado correctamente';
    const ALERT_VALIDATE_FAIL = 'Error al validar';

    /**
     * Crea mensaje de alerta en el sistema
     * @param $type
     * @param $message
     */
    public static function alert($type, $message)
    {
        if (is_array($message)) {
            $message = explode('<br>', $message);
        }

        $session = new Session();
        $session->set('alertMessage', $message);
        $session->set('alertType', $type);
    }

    /**
     * Alerta exitosa
     * @param $message
     */
    public static function alertSuccess($message)
    {
        self::alert(self::ALERT_SUCCESS, $message);
    }

    /**
     * Alerta fallida
     * @param $message
     */
    public static function alertFail($message)
    {
        self::alert(self::ALERT_FAIL, $message);
    }

    /**
     * Retorna si existen mensajes de alerta actualmente
     * @return bool
     */
    public function hasAlert()
    {
        $session = new Session();

        return $session->has('alertType') && $session->has('alertMessage');
    }

    /**
     * Remueve el tipo de alerta
     */
    public static function removeAlertType()
    {
        $session = new Session();
        $session->remove('alertType');
    }

    /**
     * Remueve el mensaje de alerta
     */
    public static function removeAlertMessage()
    {
        $session = new Session();
        $session->remove('alertMessage');
    }

    /**
     * Limpia mensajes de alerta
     */
    public static function clear()
    {
        $session = new Session();
        $session->remove('alertType');
        $session->remove('alertMessage');
    }

    /**
     * Retorna el tipo de mensaje de alerta
     * @return string
     */
    public static function getAlertType()
    {
        $session = new Session();

        return $session->get('alertType');
    }

    /**
     * Retorna el mensaje de alerta
     * @return string
     */
    public static function getAlertMessage()
    {
        $session = new Session();

        return $session->get('alertMessage');
    }

    /**
     * Retorna el tipo de alerta y lo remueve de la session
     * @return string
     */
    public static function getAlertTypeAndRemove()
    {
        $alertType = self::getAlertType();
        self::removeAlertType();

        return $alertType;
    }

    /**
     * Retorna el mensaje de alerta y lo remueve de la session
     * @return string
     */
    public static function getAlertMessageAndRemove()
    {
        $alertMessage = self::getAlertMessage();
        self::removeAlertMessage();

        return $alertMessage;
    }

    /**
     * Guarda una alerta con lista de errores de formulario
     * @param $formErrors
     */
    public static function alertFormErrors($formErrors)
    {
        $message = '';

        foreach ($formErrors as $error) {
            $message .= $error->getMessage() . '<br>';
        }

        self::alertFail($message);
    }
}