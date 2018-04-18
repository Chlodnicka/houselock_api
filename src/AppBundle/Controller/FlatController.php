<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 13:14
 */

namespace AppBundle\Controller;


use AppBundle\Collection\Serialized\Serialized;
use AppBundle\Entity\User;
use AppBundle\Service\FlatService;
use AppBundle\Service\MailerService;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class FlatController extends Controller
{
    /**
     * @var FlatService
     */
    private $flatService;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var MailerService
     */
    private $mailerService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(FlatService $flatService,
                                AuthorizationCheckerInterface $authorizationChecker,
                                UserService $userService,
                                MailerService $mailerService)
    {
        $this->flatService = $flatService;
        $this->userService = $userService;
        $this->authorizationChecker = $authorizationChecker;
        $this->mailerService = $mailerService;
    }

    /**
     * @Route("/api/flats.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="flat_list")
     */
    public function indexAction(Request $request)
    {
        //get list of flats for landlord
        /**
         * @var $user User|null
         */
        $user = $this->getUser();
        $flatList = null;
        if ($user) {
            $flatList = new Serialized($user->getUserFlats());
        }

        $response = new JsonResponse(['flat_list' => '']);
//        $response->headers->set('Access-Control-Allow-Origin', '*');
//        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//        $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
        return $response;
    }

    /**
     * @Route("/api/flat/{id}.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="flat_show")
     * @Method("GET")
     */
    public function showAction(int $id)
    {
        //show flat (address/config/prices)
        $flat = $this->flatService->checkUserFlat($this->getUser(), $id);
        return new JsonResponse(['flat_info' => new Serialized($flat)]);
    }

    /**
     * @Route("/api/flat/create.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="flat_show_address")
     * @Method("POST")
     */
    public function createFlatAction(Request $request)
    {
        $data = $request->request->all();
        $flat = $this->flatService->createFlat($this->getUser(), $data);
        return new JsonResponse(['flat_info' => new Serialized($flat)]);
    }

    /**
     * @Route("/api/flat/{id}.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="flat_show_address")
     * @Method("POST")
     */
    public function updateFlatAction(Request $request, int $id)
    {
        $data = $request->request->all();
        $flat = $this->flatService->checkUserFlat($this->getUser(), $id);
        if ($flat) {
            $flat = $this->flatService->updateFlat($this->getUser(), $flat, $data);
        }
        return new JsonResponse(['flat_info' => new Serialized($flat)]);
    }


    /**
     * @Route("/api/{flatId}/users.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"}, name="flat_users_list")
     * @Method("GET")
     */
    public function usersAction(Request $request, int $id)
    {
        $flat = $this->flatService->checkUserFlat($this->getUser(), $id);
        $tenants = null;
        if ($flat) {
            //fix tennants
            $tenants = $this->flatService->getTenants($flat);
        }
        return new JsonResponse(['flat_users' => new Serialized($tenants)]);
    }

    /**
     * @Route("/api/flat/user/{id}invite.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"}, name="invite_user")
     * @Method("GET")
     */
    public function invitationAction(Request $request, int $id)
    {
        $flat = $this->flatService->checkUserFlat($this->getUser(), $id);
        if ($flat) {
            $data = $request->request->all();
            $response = $this->userService->addTenants($this->getUser(), $data);
            if (!empty($response['tenants'])) {
                $tenants = $this->flatService->addUsersToFlat($flat, $response['tenants']);
                foreach ($tenants as $tenant) {
                    $this->mailerService->sendInvitationMail($tenant);
                }
            }
        }
        //add user to flat
        //send mail to user
        //return successful response
        return new JsonResponse(['invite_user']);
    }

    /**
     * @Route("/api/flat/{id}/delete.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="delete_flat")
     * @Method("GET")
     */
    public function deleteAction(Request $request, int $id)
    {
        $flat = $this->flatService->checkUserFlat($this->getUser(), $id);
        return new JsonResponse(['delete_flat']);
    }
}