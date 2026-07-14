<?php

declare(strict_types=1);

namespace ErlichFliesen\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SeoSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // TODO: Implement getSubscribedEvents() method. I need to replace the SEO PATH automagic. I do not want to manualy keeping track of the url path
        return[];
    }
}
