<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Services\TaskService;

class ToDoListController extends AbstractController
{
    /**
     * @Route("/", name="to_do_list")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id' => 'DESC']);
        return $this->render('list.html.twig', ['tasks' => $tasks]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request, TaskService $taskService): RedirectResponse
    {
        $title = $request->request->get('title');

        if (empty($title)) {
            return $this->redirectToRoute('to_do_list');
        }

        $taskService->create($title);

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/switch-status/{id}", name="switch-status")
     */
    public function switchStatus(TaskService $taskService, $id): RedirectResponse
    {
        $taskService->switch($id);
        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(TaskService $taskService, $id): RedirectResponse
    {
        $taskService->delete($id);
        return $this->redirectToRoute('to_do_list');
    }
}
