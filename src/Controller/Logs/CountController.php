<?php

namespace App\Controller\Logs;

use App\Model\RequestLogCriteria;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RequestLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/count', name: 'log_aggregation_count', methods: 'GET')]
class CountController extends AbstractController
{

    public function __invoke(
        #[MapQueryString] ?RequestLogCriteria $criteria,
        RequestLogRepository $repository
    ): JsonResponse
    {
        if (!$criteria) {
            $criteria = new RequestLogCriteria();
        }

        return $this->json(['counter' => $repository->getNumberOfRecords($criteria)], Response::HTTP_OK);
    }

}