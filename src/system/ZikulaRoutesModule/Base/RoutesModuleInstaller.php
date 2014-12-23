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

namespace Zikula\RoutesModule\Base;

use DoctrineHelper;
use EventUtil;
use HookUtil;
use ModUtil;
use System;
use UserUtil;
use Zikula_AbstractInstaller;
use Zikula_Workflow_Util;

/**
 * Installer base class.
 */
class RoutesModuleInstaller extends Zikula_AbstractInstaller
{
    /**
     * Install the ZikulaRoutesModule application.
     *
     * @return boolean True on success, or false.
     *
     * @throws RuntimeException Thrown if database tables can not be created or another error occurs
     */
    public function install()
    {
        // create all tables from according entity definitions
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->listEntityClasses());
        } catch (\Exception $e) {
            if (System::isDevelopmentMode()) {
                $this->request->getSession()->getFlashBag()->add('error', $this->__('Doctrine Exception: ') . $e->getMessage());
                $logger = $this->serviceManager->get('logger');
                $logger->error('{app}: User {user} could not create the database tables during installation. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
                return false;
            }
            $returnMessage = $this->__f('An error was encountered while creating the tables for the %s extension.', array($this->name));
            if (!System::isDevelopmentMode()) {
                $returnMessage .= ' ' . $this->__('Please enable the development mode by editing the /app/config/parameters.yml file (change the env variable to dev) in order to reveal the error details.');
            }
            $this->request->getSession()->getFlashBag()->add('error', $returnMessage);
            $logger = $this->serviceManager->get('logger');
            $logger->error('{app}: User {user} could not create the database tables during installation. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
            return false;
        }
    
        // set up all our vars with initial values
        $this->setVar('moderationGroupForRoutes', 2);
    
        $categoryRegistryIdsPerEntity = array();
    
        // create the default data
        $this->createDefaultData($categoryRegistryIdsPerEntity);
    
        // register hook subscriber bundles
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());
        
    
        // initialisation successful
        return true;
    }
    
    /**
     * Upgrade the ZikulaRoutesModule application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldVersion Version to upgrade from.
     *
     * @return boolean True on success, false otherwise.
     *
     * @throws RuntimeException Thrown if database tables can not be updated
     */
    public function upgrade($oldVersion)
    {
    /*
        // Upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // do something
                // ...
                // update the database schema
                try {
                    DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
                } catch (\Exception $e) {
                    if (System::isDevelopmentMode()) {
                        $this->request->getSession()->getFlashBag()->add('error', $this->__('Doctrine Exception: ') . $e->getMessage());
                        $logger = $this->serviceManager->get('logger');
                        $logger->error('{app}: User {user} could not update the database tables during the upgrade. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
                        return false;
                    }
                    $this->request->getSession()->getFlashBag()->add('error', $this->__f('An error was encountered while updating tables for the %s extension.', array($this->getName())));
                    $logger = $this->serviceManager->get('logger');
                    $logger->error('{app}: User {user} could not update the database tables during the ugprade. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
                    return false;
                }
        }
    
        // Note there are several helpers available for making migration of your extension easier.
        // The following convenience methods are each responsible for a single aspect of upgrading to Zikula 1.4.0.
    
        // here is a possible usage example
        // of course 1.2.3 should match the number you used for the last stable 1.3.x module version.
        /* if ($oldVersion = '1.2.3') {
            // rename module for all modvars
            $this->updateModVarsTo140();
            
            // update extension information about this app
            $this->updateExtensionInfoFor140();
            
            // rename existing permission rules
            $this->renamePermissionsFor140();
            
            // rename existing category registries
            $this->renameCategoryRegistriesFor140();
            
            // rename all tables
            $this->renameTablesFor140();
            
            // remove event handler definitions from database
            $this->dropEventHandlersFromDatabase();
            
            // update module name in the hook tables
            $this->updateHookNamesFor140();
        } * /
    */
    
        // update successful
        return true;
    }
    
    /**
     * Renames the module name for variables in the module_vars table.
     */
    protected function updateModVarsTo140()
    {
        $dbName = $this->getDbName();
        $conn = $this->getConnection();
    
        $conn->executeQuery("UPDATE $dbName.module_vars
                             SET modname = 'ZikulaRoutesModule'
                             WHERE modname = 'Routes';
        ");
    }
    
    /**
     * Renames this application in the core's extensions table.
     */
    protected function updateExtensionInfoFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $conn->executeQuery("UPDATE $dbName.modules
                             SET name = 'ZikulaRoutesModule',
                                 directory = 'Zikula/RoutesModule'
                             WHERE name = 'Routes';
        ");
    }
    
    /**
     * Renames all permission rules stored for this app.
     */
    protected function renamePermissionsFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $componentLength = strlen('Routes') + 1;
    
        $conn->executeQuery("UPDATE $dbName.group_perms
                             SET component = CONCAT('ZikulaRoutesModule', SUBSTRING(component, $componentLength))
                             WHERE component LIKE 'Routes%';
        ");
    }
    
    /**
     * Renames all category registries stored for this app.
     */
    protected function renameCategoryRegistriesFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $componentLength = strlen('Routes') + 1;
    
        $conn->executeQuery("UPDATE $dbName.categories_registry
                             SET modname = CONCAT('ZikulaRoutesModule', SUBSTRING(component, $componentLength))
                             WHERE modname LIKE 'Routes%';
        ");
    }
    
    /**
     * Renames all (existing) tables of this app.
     */
    protected function renameTablesFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $oldPrefix = 'routes_';
        $oldPrefixLength = strlen($oldPrefix);
        $newPrefix = 'zikula_routes_';
    
        $sm = $conn->getSchemaManager();
        $tables = $sm->listTables();
        foreach ($tables as $table) {
            $tableName = $table->getName();
            if (substr($tableName, 0, $oldPrefixLength) != $oldPrefix) {
                continue;
            }
    
            $newTableName = str_replace($oldPrefix, $newPrefix, $tableName);
    
            $conn->executeQuery("RENAME TABLE $dbName.$tableName
                                 TO $dbName.$newTableName;
            ");
        }
    }
    
    /**
     * Removes event handlers from database as they are now described by service definitions and managed by dependency injection.
     */
    protected function dropEventHandlersFromDatabase()
    {
        EventUtil::unregisterPersistentModuleHandlers('Routes');
    }
    
    /**
     * Updates the module name in the hook tables.
     */
    protected function updateHookNamesFor140()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $conn->executeQuery("UPDATE $dbName.hook_area
                             SET owner = 'ZikulaRoutesModule'
                             WHERE owner = 'Routes';
        ");
    
        $componentLength = strlen('subscriber.routes') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_area
                             SET areaname = CONCAT('subscriber.zikularoutesmodule', SUBSTRING(areaname, $componentLength))
                             WHERE areaname LIKE 'subscriber.routes%';
        ");
    
        $conn->executeQuery("UPDATE $dbName.hook_binding
                             SET sowner = 'ZikulaRoutesModule'
                             WHERE sowner = 'Routes';
        ");
    
        $conn->executeQuery("UPDATE $dbName.hook_runtime
                             SET sowner = 'ZikulaRoutesModule'
                             WHERE sowner = 'Routes';
        ");
    
        $componentLength = strlen('routes') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_runtime
                             SET eventname = CONCAT('zikularoutesmodule', SUBSTRING(eventname, $componentLength))
                             WHERE eventname LIKE 'routes%';
        ");
    
        $conn->executeQuery("UPDATE $dbName.hook_subscriber
                             SET owner = 'ZikulaRoutesModule'
                             WHERE owner = 'Routes';
        ");
    
        $componentLength = strlen('routes') + 1;
        $conn->executeQuery("UPDATE $dbName.hook_subscriber
                             SET eventname = CONCAT('zikularoutesmodule', SUBSTRING(eventname, $componentLength))
                             WHERE eventname LIKE 'routes%';
        ");
    }
    
    /**
     * Returns connection to the database.
     *
     * @return Connection the current connection.
     */
    protected function getConnection()
    {
        $em = $this->entityManager;
        $conn = $em->getConnection();
    
        return $conn;
    }
    
    /**
     * Returns the name of the default system database.
     *
     * @return string the database name.
     */
    protected function getDbName()
    {
        return $this->getContainer()->getParameter('database_name');
    }
    
    /**
     * Uninstall ZikulaRoutesModule.
     *
     * @return boolean True on success, false otherwise.
     *
     * @throws RuntimeException Thrown if database tables or stored workflows can not be removed
     */
    public function uninstall()
    {
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule($this->getName());
        if ($result === false) {
            $this->request->getSession()->getFlashBag()->add('error', $this->__f('An error was encountered while removing stored object workflows for the %s extension.', array($this->getName())));
            $logger = $this->serviceManager->get('logger');
            $logger->error('{app}: User {user} could not remove stored object workflows during uninstallation.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname')));
            return false;
        }
    
        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->listEntityClasses());
        } catch (\Exception $e) {
            if (System::isDevelopmentMode()) {
                $this->request->getSession()->getFlashBag()->add('error', $this->__('Doctrine Exception: ') . $e->getMessage());
                $logger = $this->serviceManager->get('logger');
                $logger->error('{app}: User {user} could not remove the database tables during uninstallation. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
                return false;
            }
            $this->request->getSession()->getFlashBag()->add('error', $this->__f('An error was encountered while dropping tables for the %s extension.', array($this->name)));
            $logger = $this->serviceManager->get('logger');
            $logger->error('{app}: User {user} could not remove the database tables during uninstallation. Error details: {errorMessage}.', array('app' => 'ZikulaRoutesModule', 'user' => UserUtil::getVar('uname'), 'errorMessage' => $e->getMessage()));
            return false;
        }
    
        // unregister hook subscriber bundles
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());
        
    
        // remove all module vars
        $this->delVars();
    
        // uninstallation successful
        return true;
    }
    
    /**
     * Build array with all entity classes for ZikulaRoutesModule.
     *
     * @return array list of class names.
     */
    protected function listEntityClasses()
    {
        $classNames = array();
        $classNames[] = 'Zikula\RoutesModule\Entity\RouteEntity';
    
        return $classNames;
    }
    
    /**
     * Create the default data for ZikulaRoutesModule.
     *
     * @param array $categoryRegistryIdsPerEntity List of category registry ids.
     *
     * @return void
     */
    protected function createDefaultData($categoryRegistryIdsPerEntity)
    {
        $entityClass = 'ZikulaRoutesModule:RouteEntity';
        $this->entityManager->getRepository($entityClass)->truncateTable();
    }
}
