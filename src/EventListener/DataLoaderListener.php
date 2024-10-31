<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Service\FileSystemService;

class DataLoaderListener implements EventSubscriberInterface
{


    public function __construct(private FileSystemService $fileSystemService)
    {
        
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if($event->getRequest()->attributes->get('_route') === 'homePage')
        {
            $this->fileSystemService->fileProcessCsv();
        }

        elseif ($event->getRequest()->attributes->get('_route') === 'json_data') {
            
            $this->fileSystemService->jsonFileProcess();
        }
         
        elseif ($event->getRequest()->attributes->get('_route') === 'ldif-file') {
            
            $this->fileSystemService->ldifFileService();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}