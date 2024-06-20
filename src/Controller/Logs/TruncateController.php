<?php

namespace App\Controller\Logs;

use App\Message\TruncateTable\TruncateTableMessage;
use App\Model\TruncateTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/delete', name: 'table_truncate', methods: 'POST')]
class TruncateController extends AbstractController
{

    public function __invoke(
        #[MapRequestPayload] TruncateTable $truncateTable,
        MessageBusInterface $bus
    ): JsonResponse
    {

        if (!$truncateTable->getTableName()) {
            return $this->json([
                'error' => 'Table property is required'
            ], Response::HTTP_BAD_REQUEST);
        }

        $bus->dispatch(new TruncateTableMessage($truncateTable->getTableName()));

        return $this->json(true, Response::HTTP_OK);
    }

}