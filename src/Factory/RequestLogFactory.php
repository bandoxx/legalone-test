<?php

namespace App\Factory;

use App\Entity\RequestLog;

class RequestLogFactory
{
    public function createFromLine(string $log): ?RequestLog
    {
        $pattern = '/^(.*?) - - \[(.*?)] "(.*?)" (\d+)$/';

        if (!preg_match($pattern, trim($log), $matches)) {
            return null;
        }

        return (new RequestLog())
            ->setServiceName($matches[1])
            ->setDate((new \DateTime($matches[2])))
            ->setStatusCode($matches[4])
        ;
    }

    // in case we need more detailed version
    //public function createFromLine(string $log): array
    //{
    //    $requestLog = null;
    //
    //    $pattern = '/^(.*?) - - \[(.*?)\] "(.*?)" (\d+)$/';
    //    if (preg_match($pattern, trim($log), $matches)) {
    //        $service = $matches[1];
    //        $dateTime = $matches[2];
    //        $request = $matches[3];
    //        $status = $matches[4];
    //    }
    //
    //    // Further parse the request part
    //    $requestPattern = '/^(.*?) (.*?) (HTTP\/\d\.\d)$/';
    //    if (preg_match($requestPattern, $request, $requestMatches)) {
    //        $httpMethod = $requestMatches[1];
    //        $path = $requestMatches[2];
    //        $httpVersion = $requestMatches[3];
    //
    //        return [
    //            'date' => new \DateTime($dateTime),
    //            'service_name' => $service,
    //            'status_code' => $status,
    //            'path' => $path,
    //            'http_method' => $httpMethod
    //        ];
    //    }
    //
    //    return $requestLog;
    //}

}