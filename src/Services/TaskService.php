<?php

namespace App\Services;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class TaskService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($title)
    {
        $task = new Task();
        $task->setTitle($title);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function switch($id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        $task->setStatus( ! $task->isStatus() );
        $this->entityManager->flush();
    }

    public function delete($id)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}