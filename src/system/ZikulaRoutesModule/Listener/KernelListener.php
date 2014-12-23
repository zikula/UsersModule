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

namespace Zikula\RoutesModule\Listener;

use Zikula\RoutesModule\Listener\Base\KernelListener as BaseKernelListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Event handler implementation class for Symfony kernel events.
 */
class KernelListener extends BaseKernelListener
{

    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents();
    }

    /**
     * Listener for the `kernel.request` event.
     *
     * Occurs after the request handling has started.
     *
     * If possible you can return a Response object directly (for example showing a "maintenance mode" page).
     * The first listener returning a response stops event propagation.
     * Also you can initialise variables and inject information into the request attributes.
     *
     * Example from Symfony: the RouterListener determines controller and information about arguments.
     *
     * @param GetResponseEvent $event The event instance.
     */
    public function onRequest(GetResponseEvent $event)
    {
        parent::onRequest($event);

        // if we return a response the system jumps to the kernel.response event
        // immediately without executing any other listeners or controllers
        // $event->setResponse(new Response('This site is currently not active!'));

        // init stuff and add it to the request (for example a locale)
        // $testMessage = 'Hello from routes app';
        // $event->getRequest()->attributes->set('ZikulaRoutesModule_test', $testMessage);

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.controller` event.
     *
     * Occurs after routing has been done and the controller has been selected.
     *
     * You can initialise things requiring the controller and/or routing information.
     * Also you can change the controller before it is executed.
     *
     * Example from Symfony: the ParamConverterListener performs reflection and type conversion.
     *
     * @param FilterControllerEvent $event The event instance.
     */
    public function onController(FilterControllerEvent $event)
    {
        parent::onController($event);

        // $controller = $event->getController();
        // ...

        // the controller can be changed to any PHP callable
        // $event->setController($controller);


        // check for certain controller types (or implemented interface types!)
        // for example imagine an interface named SpecialFlaggedController

        // The passed $controller passed can be either a class or a Closure.
        // If it is a class, it comes in array format.
        // if (!is_array($controller)) {
        //     return;
        // }

        // if ($controller[0] instanceof SpecialFlaggedController) {
        //     ...
        // }

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.view` event.
     *
     * Occurs only if the controller did not return a Response object.
     *
     * You can convert the controller's return value into a Response object.
     * This is useful for own view layers.
     * The first listener returning a response stops event propagation.
     *
     * Example from Symfony: TemplateListener renders Twig templates with returned arrays.
     *
     * @param GetResponseForControllerResultEvent $event The event instance.
     */
    public function onView(GetResponseForControllerResultEvent $event)
    {
        parent::onView($event);

        // $val = $event->getControllerResult();

        // $response = new Response();

        // ... customise the response using the return value

        // $event->setResponse($response);

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.response` event.
     *
     * Occurs after a response has been created and returned to the kernel.
     *
     * You can modify or replace the response object, including http headers,
     * cookies, and so on. Of course you can also amend the actual content by
     * for example injecting some custom JavaScript code.
     * Of course you can use request attributes you set in onKernelRequest
     * or onKernelController or other events happened before.
     *
     * Examples from Symfony:
     *    - ContextListener: serialises user data into session for next request
     *    - WebDebugToolbarListener: injects the web debug toolbar
     *    - ResponseListener: updates the content type according to the request format
     *
     * @param FilterResponseEvent $event The event instance.
     */
    public function onResponse(FilterResponseEvent $event)
    {
        parent::onResponse($event);

        // $response = $event->getResponse();

        // ... modify the response object

        // $testMessage = $event->getRequest()->attributes->get('ZikulaRoutesModule_test');
        // now $testMessage should be: 'Hello from routes app'

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.finish_request` event.
     *
     * Occurs after processing a request has been completed.
     * Called after a normal response as well as after an exception was thrown.
     *
     * You can cleanup things here which are not directly related to the response.
     *
     * @param FinishRequestEvent $event The event instance.
     */
    public function onFinishRequest(FinishRequestEvent $event)
    {
        parent::onFinishRequest($event);

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.terminate` event.
     *
     * Occurs before the system is shutted down.
     *
     * You can perform any bigger tasks which can be delayed until the Response
     * has been served to the client. One example is sending some spooled emails.
     *
     * Example from Symfony: SwiftmailerBundle with memory spooling activates an
     * EmailSenderListener which delivers emails created during the request.
     *
     * @param PostResponseEvent $event The event instance.
     */
    public function onTerminate(PostResponseEvent $event)
    {
        parent::onTerminate($event);

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }

    /**
     * Listener for the `kernel.exception` event.
     *
     * Occurs whenever an exception is thrown. Handles (different types
     * of) exceptions and creates a fitting Response object for them.
     *
     * You can inject custom error handling for specific error types.
     *
     * @param GetResponseForExceptionEvent $event The event instance.
     */
    public function onException(GetResponseForExceptionEvent $event)
    {
        parent::onException($event);

        // retrieve exception object from the received event
        // $exception = $event->getException();

        // if ($exception instanceof MySpecialException
        //     || $exception instanceof MySpecialExceptionInterface) {
            // Create a response object and customise it to display the exception details
            // $response = new Response();

            // $message = sprintf(
            //     'routes App Error says: %s with code: %s',
            //     $exception->getMessage(),
            //     $exception->getCode()
            // );

            // $response->setContent($message);

            // HttpExceptionInterface is a special type of exception that
            // holds the status code and header details
            // if ($exception instanceof HttpExceptionInterface) {
            //     $response->setStatusCode($exception->getStatusCode());
            //     $response->headers->replace($exception->getHeaders());
            // } else {
            //     $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            // }

            // send modified response back to the event
            // $event->setResponse($response);
        // }

        // you can alternatively set a new Exception
        // $exception = new \Exception('Some special exception');
        // $event->setException($exception);

        // you can access general data available in the event

        // the event name
        // echo 'Event: ' . $event->getName();

        // type of current request: MASTER_REQUEST or SUB_REQUEST
        // if a listener should only be active for the master request,
        // be sure to check that at the beginning of your method
        // if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
        //     // don't do anything if it's not the master request
        //     return;
        // }

        // kernel instance handling the current request
        // $kernel = $event->getKernel();

        // the currently handled request
        // $request = $event->getRequest();
    }
}
