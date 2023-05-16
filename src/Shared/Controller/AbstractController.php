<?php

declare(strict_types=1);

namespace App\Shared\Controller;

use App\Shared\Response\StsJsonResponse;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected function jsonResponse(string $content = '', int $status = StsJsonResponse::HTTP_NO_CONTENT, array $headers = []): StsJsonResponse
    {
        return new StsJsonResponse($content, $status, $headers);
    }
}
