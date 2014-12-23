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

/**
 * Permission check for workflow schema 'standard'.
 * This function allows to calculate complex permission checks.
 * It receives the object the workflow engine is being asked to process and the permission level the action requires.
 *
 * @param array  $obj         The currently treated object.
 * @param int    $permLevel   The required workflow permission level.
 * @param int    $currentUser Id of current user.
 * @param string $actionId    Id of the workflow action to be executed.
 *
 * @return bool Whether the current user is allowed to execute the action or not.
 */
function ZikulaRoutesModule_workflow_standard_permissioncheck($obj, $permLevel, $currentUser, $actionId)
{
    if (\System::isInstalling()) {
        return true;
    }

    // calculate the permission component
    $objectType = $obj['_objectType'];
    $component = 'ZikulaRoutesModule:' . ucfirst($objectType) . ':';

    // calculate the permission instance
    $idFields = ModUtil::apiFunc('ZikulaRoutesModule', 'selection', 'getIdFields', array('ot' => $objectType));
    $instanceId = '';
    foreach ($idFields as $idField) {
        if (!empty($instanceId)) {
            $instanceId .= '_';
        }
        $instanceId .= $obj[$idField];
    }
    $instance = $instanceId . '::';

    // now perform the permission check
    $result = SecurityUtil::checkPermission($component, $instance, $permLevel, $currentUser);

    return $result;
}

/**
 * This helper functions cares for including the strings used in the workflow into translation.
 */
function ZikulaRoutesModule_workflow_standard_gettextstrings()
{
    return array(
        'title' => no__('Standard workflow (single approval)'),
        'description' => no__('This is a two staged workflow with stages for untrusted submissions and finally approved publications. It does not allow corrections of non-editors to published pages.'),

        // state titles
        'states' => array(
            no__('Initial') => no__('Pseudo-state for content which is just created and not persisted yet.'),
            no__('Waiting') => no__('Content has been submitted and waits for approval.'),
            no__('Approved') => no__('Content has been approved and is available online.'),
            no__('Deleted') => no__('Pseudo-state for content which has been deleted from the database.')
        ),

        // action titles and descriptions for each state
        'actions' => array(
            'initial' => array(
                no__('Submit') => no__('Submit content for acceptance by a moderator.'),
                no__('Submit and Approve') => no__('Submit content and approve immediately.'),
            )
            ,
            'waiting' => array(
                no__('Update') => no__('Update content.'),
                no__('Approve') => no__('Update content and approve for immediate publishing.'),
                no__('Delete') => no__('Delete content permanently.')
            )
            ,
            'approved' => array(
                no__('Update') => no__('Update content.'),
                no__('Delete') => no__('Delete content permanently.')
            )
            ,
            'deleted' => array(
            )
        )
    );
}
