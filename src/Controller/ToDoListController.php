<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{jsonResponse, Request, Response, RedirectResponse};
use Symfony\Component\Routing\Annotation\Route;
use App\Services\TaskService;

class ToDoListController extends AbstractController
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @Route("/", name="to_do_list")
     */
    public function index(): Response
    {
        return $this->render('list.html.twig', ['tasks' => $this->taskService->getList()]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request): RedirectResponse
    {
        $title = $request->request->get('title');

        if (!empty($title)) {
            $this->taskService->create($title);
        }

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/switch-status/{id}", name="switch-status")
     */
    public function switchStatus(int $id): RedirectResponse
    {
        $this->taskService->switch($id);
        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id): RedirectResponse
    {
        $this->taskService->delete($id);
        return $this->redirectToRoute('to_do_list');
    }
}
