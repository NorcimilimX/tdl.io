<?php

declare(strict_types = 1);

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

    public function getList(): array
    {
        return $this->entityManager->getRepository(Task::class)->findBy([], ['id' => 'DESC']);
    }

    public function create(string $title): void
    {
        $task = new Task();
        $task->setTitle($title);
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function switch(int $id): void
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        $task->setStatus( ! $task->isStatus() );
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $this->entityManager->remove($this->entityManager->getRepository(Task::class)->find($id));
        $this->entityManager->flush();
    }
}