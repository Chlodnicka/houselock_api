<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 13:14
 */

namespace AppBundle\Controller;


use AppBundle\Collection\Serialized\Info;
use AppBundle\Collection\Serialized\Serialized;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/api/all.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="all")
     */
    public function infoAction()
    {
        $user = $this->getUser();
        $userData = new Info($user);
        $response = new JsonResponse(['data' => $userData->getAll()]);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
        return $response;
    }

    /**
     * @Route("/api/user/{id}.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="user")
     * @Method("GET")
     */
    public function showAction(Request $request, int $id)
    {
        $userToDisplay = $this->userService->get($id);
        if (!$this->userService->checkUserRights($this->getUser(), $userToDisplay)) {
            $userToDisplay = null;
        }
        return new JsonResponse(['user_info' => new Serialized($userToDisplay)]);
    }

    /**
     * @Route("/api/user/{id}/save.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="save_user")
     * @Method("GET")
     */
    public function updateAction(Request $request, int $id)
    {
        $data = $request->request->all();
        if ($this->getUser()->getId() === $id) {
            $user = $this->userService->updateUser($this->getUser(), $data);
            return new JsonResponse(['user_info' => $user]);
        }
        return new JsonResponse(['message' => 'no rights']);
    }

    /**
     * @Route("/api/user/{id}/password/set.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="save_user")
     * @Method("GET")
     * @param Request $request
     * @param int $id
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     */
    public function passwordSetAction(Request $request, int $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = $request->request->all();
        if ($this->getUser()->getId() === $id) {
            $user = $this->userService->setPassword($this->getUser(), $passwordEncoder, $data);
            return new JsonResponse(['user_info' => $user]);
        }
        return new JsonResponse(['message' => 'no rights']);
    }

    /**
     * @Route("/api/user/accept.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="accept_user")
     * @Method("GET")
     */
    public function acceptAction(Request $request)
    {
        //save acceptance
        return new JsonResponse(['accept_invitation']);
    }


    //remove user from flat

    //accept user removal
}