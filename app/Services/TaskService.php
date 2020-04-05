<?php

namespace App\Services;

use \Doctrine\ORM\EntityManager;
use App\Models\Task;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TaskService
{
    const SORT_BY_USER_NAME = 'user_name';
    const SORT_BY_EMAIL = 'email';
    const SORT_BY_IS_DONE = 'is_done';

    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @return array
     */
    public function getSortableColumns() :array
    {
        return [
            self::SORT_BY_USER_NAME,
            self::SORT_BY_EMAIL,
            self::SORT_BY_IS_DONE,
        ];
    }

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $sort
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getList(array $sort, int $page, int $pageSize) :array
    {
        $direction = self::DIRECTION_ASC;
        $column = 'id';
        if (isset($sort['column']) && in_array($sort['column'], $this->getSortableColumns())) {
            $column = $sort['column'];
        }

        if (
            isset($sort['direction']) &&
            in_array(mb_strtolower($sort['direction']), [self::DIRECTION_ASC, self::DIRECTION_DESC])
        ) {
            $direction = mb_strtolower($sort['direction']);
        }

        $repository = $this->entityManager->getRepository(Task::class);
        $query = $repository->createQueryBuilder('t')
            ->orderBy('t.'.$column, $direction)
            ->getQuery();

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $totalItems = $paginator->count();
        $pagesCount = ceil($totalItems / $pageSize);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page-1))
            ->setMaxResults($pageSize);

        $data = [
            'data' => [],
            'paginator' => [
                'current_page' => $page,
                'all_pages' => $pagesCount,
            ]
        ];

        foreach ($paginator as $pageItem) {
            $data['data'][] = [
                'id' => $pageItem->getId(),
                'user_name' => $pageItem->getUserName(),
                'email' => $pageItem->getEmail(),
                'description' => $pageItem->getDescription(),
                'is_done' => $pageItem->isIsDone()
            ];
        }

        return $data;
    }

    /**
     * @param Task $task
     * @param array $data
     * @return bool
     */
    public function crud(Task $task, array $data) :bool
    {
        try {
            $this->fillFromArray($task, $data);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
        } catch (ORMException $ORMException) {
            return false;
        }

        return true;
    }

    /**
     * @param Task $task
     * @param array $data
     */
    public function fillFromArray(Task $task, array $data) :void
    {
        $task->setUserName($data['user_name']);
        $task->setEmail($data['email']);
        $task->setDescription($data['description']);
        $task->setIsDone(isset($data['is_done']) ? true : false);
    }
}
