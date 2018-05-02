<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 13:14
 */

namespace AppBundle\Controller;


use AppBundle\Collection\Serialized\FlatInfo;
use AppBundle\Collection\Serialized\Info;
use AppBundle\Collection\Serialized\Serialized;
use AppBundle\Entity\User;
use AppBundle\Service\FlatService;
use AppBundle\Service\MailerService;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function flatInfoAction(int $id)
    {
        $user = $this->getUser();
        if ($user && $this->flatService->checkUserFlat($user, $id)) {
            $flatInfo = new FlatInfo($this->flatService->getFlat($id));
            return new JsonResponse(['data' => $flatInfo->getAll()]);
        }
        return new JsonResponse(['message' => 'Brak autoryzacji do mieszkania'], 500);
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
     * @Route("/api/flat/{id}/user/add.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="user_add")
     * @Method("POST")
     */
    public function addUserAction(Request $request, int $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        try {
            $flat = $this->flatService->getFlat($id);
            if ($this->getUser() && $this->flatService->checkUserFlat($this->getUser(), $id)) {
                $user = $this->userService->addTenant($this->getUser(), $request->request->get('_email'), $passwordEncoder);
                if ($user->getActiveUserFlats()->isEmpty()) {
                    $this->flatService->addTenantToFlat($flat, $user);
                    $userData = new FlatInfo($flat);
                    return new JsonResponse(['data' => $userData->getAll()]);
                }
                return new JsonResponse(['data' => 'Ten lokator jest już przypisany do innego mieszkania', 500]);
            }
            return new JsonResponse(['data' => 'Błędne dane', 500]);
        } catch (\Exception $exception) {
            return new JsonResponse(['data' => $exception->getMessage(), 500]);
        }
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