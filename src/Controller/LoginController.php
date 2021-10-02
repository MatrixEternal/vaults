<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\User;
use App\Entity\Vault;
use App\Repository\LoginRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class LoginController extends AbstractController
{
    private LoginRepository $repository;

    private SerializerInterface $serializer;

    public function __construct(LoginRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    /**
     * Queries the database by the given user id and returns all(if any) found vaults.
     *
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
    {
        $responseCode = 200;

        $vaults = $this->repository->findMultipleByUserId(
            $request->get("userId")
        );

        if (empty($vaults)) {
            $responseCode = 404;
        }

        return new JsonResponse($vaults, $responseCode);
    }

    /**
     * Given encrypted data and a user id that owns it, persists that data as a new entity.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $requestBody = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->find($requestBody["userId"]);

        $vault = $this->getDoctrine()
                        ->getRepository(Vault::class)
                        ->find($requestBody["vaultId"]);

        $login = new Login();
        $login->setData($requestBody["data"]);
        $login->setUser($user);
        $login->setVault($vault);

        $entityManager->persist($login);
        $entityManager->flush();

        $serialized = $this->serializer->serialize($login, "json", ["attributes"  => [
            "id",
            "data"
        ]]);

        return new Response($serialized, 201);
    }

    public function update(Request $request, string $id): Response
    {
        return new Response("");
    }

    public function delete(Request $request, string $id): Response
    {
        return new Response("");
    }
}
