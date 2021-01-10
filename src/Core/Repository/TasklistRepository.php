<?php

namespace Core\Repository;

/**
 * TasklistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TasklistRepository extends \Doctrine\ORM\EntityRepository
{

    public function getTasklistsRowsForCommandLine(iterable $tasks = []) {
        $taskTableRows = [];
    
        foreach ($tasks as $task) {
            $taskTableRows[] = [
                $task->getCompleted() ? '✔' : '⃞',
                $task->getTitle(), 
                $task->getPriority(), 
                $task->getFlagged() ? '⚑' : '⚐'
            ];
            $taskTableRows[] = [''];
        }
    
        return $taskTableRows;
    }
}
