<?php
/**
 * Routes.
 *
 * @copyright Zikula contributors (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula contributors <support@zikula.org>.
 * @link http://www.zikula.org
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

namespace Zikula\RoutesModule\Util\Base;

use DataUtil;
use Zikula_AbstractBase;
use Zikula_Request_Http;

/**
 * Utility base class for controller helper methods.
 */
class ControllerUtil extends Zikula_AbstractBase
{
    /**
     * Returns an array of all allowed object types in ZikulaRoutesModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util).
     * @param array  $args    Additional arguments.
     *
     * @return array List of allowed object types.
     */
    public function getObjectTypes($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'))) {
            $context = 'controllerAction';
        }

        $allowedObjectTypes = array();
        $allowedObjectTypes[] = 'route';

        return $allowedObjectTypes;
    }

    /**
     * Returns the default object type in ZikulaRoutesModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util).
     * @param array  $args    Additional arguments.
     *
     * @return string The name of the default object type.
     */
    public function getDefaultObjectType($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'))) {
            $context = 'controllerAction';
        }

        $defaultObjectType = 'route';

        return $defaultObjectType;
    }

    /**
     * Checks whether a certain entity type uses composite keys or not.
     *
     * @param string $objectType The object type to retrieve.
     *
     * @return boolean Whether composite keys are used or not.
     */
    public function hasCompositeKeys($objectType)
    {
        switch ($objectType) {
            case 'route':
                return false;
                default:
                    return false;
        }
    }

    /**
     * Retrieve identifier parameters for a given object type.
     *
     * @param Zikula_Request_Http $request    Instance of Zikula_Request_Http.
     * @param array               $args       List of arguments used as fallback if request does not contain a field.
     * @param string              $objectType Name of treated entity type.
     * @param array               $idFields   List of identifier field names.
     *
     * @return array List of fetched identifiers.
     */
    public function retrieveIdentifier(Zikula_Request_Http $request, array $args, $objectType = '', array $idFields)
    {
        $idValues = array();
        $routeParams = $request->get('_route_params', array());
        foreach ($idFields as $idField) {
            $defaultValue = isset($args[$idField]) && is_numeric($args[$idField]) ? $args[$idField] : 0;
            if ($this->hasCompositeKeys($objectType)) {
                // composite key may be alphanumeric
                if (array_key_exists($idField, $routeParams)) {
                    $id = !empty($routeParams[$idField]) ? $routeParams[$idField] : $defaultValue;
                } elseif ($request->query->has($idField)) {
                    $id = $request->query->filter($idField, $defaultValue, false);
                } else {
                    $id = $defaultValue;
                }
            } else {
                // single identifier
                if (array_key_exists($idField, $routeParams)) {
                    $id = (int) !empty($routeParams[$idField]) ? $routeParams[$idField] : $defaultValue;
                } elseif ($request->query->has($idField)) {
                    $id = (int) $request->query->filter($idField, $defaultValue, false, FILTER_VALIDATE_INT);
                } else {
                    $id = $defaultValue;
                }
            }

            // fallback if id has not been found yet
            if (!$id && $idField != 'id' && count($idFields) == 1) {
                $defaultValue = isset($args['id']) && is_numeric($args['id']) ? $args['id'] : 0;
                if (array_key_exists('id', $routeParams)) {
                    $id = (int) !empty($routeParams['id']) ? $routeParams['id'] : $defaultValue;
                } elseif ($request->query->has('id')) {
                    $id = (int) $request->query->filter('id', $defaultValue, false, FILTER_VALIDATE_INT);
                } else {
                    $id = $defaultValue;
                }
            }
            $idValues[$idField] = $id;
        }

        return $idValues;
    }

    /**
     * Checks if all identifiers are set properly.
     *
     * @param array  $idValues List of identifier field values.
     *
     * @return boolean Whether all identifiers are set or not.
     */
    public function isValidIdentifier(array $idValues)
    {
        if (!count($idValues)) {
            return false;
        }

        foreach ($idValues as $idField => $idValue) {
            if (!$idValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create nice permalinks.
     *
     * @param string $name The given object title.
     *
     * @return string processed permalink.
     * @deprecated made obsolete by Doctrine extensions.
     */
    public function formatPermalink($name)
    {
        $name = str_replace(array('?', '?', '?', '?', '?', '?', '?', '.', '?', '"', '/', ':', '?', '?', '?'),
                            array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-', '-', 'e', 'e', 'a'),
                            $name);
        $name = DataUtil::formatPermalink($name);

        return strtolower($name);
    }
}
