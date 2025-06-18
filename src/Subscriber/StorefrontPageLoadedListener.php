<?php

/**
 * Free to use, modify, distribute. No warranty. Include license.
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Subscriber;

use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Storefront\Page\GenericPageLoadedEvent;
use SwCommerce\JavascriptCSSInjector\Service\ResourcesService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsEventListener(GenericPageLoadedEvent::class)]
class StorefrontPageLoadedListener
{
    public const CODE_SNIPPETS = 'codeSnippets';

    public function __construct(
        private readonly ResourcesService $resourcesService,
        private readonly RequestStack $requestStack
    ) {
    }

    public function __invoke(GenericPageLoadedEvent $event): void
    {
        $context = $event->getSalesChannelContext();
        $request = $this->requestStack->getCurrentRequest();
        $path = $request ? $request->getPathInfo() : '';

        $js = $this->resourcesService->getResources(ResourcesService::JS, $context, $path);
        $css = $this->resourcesService->getResources(ResourcesService::CSS, $context, $path);

        $event->getPage()->addExtension(
            self::CODE_SNIPPETS,
            new ArrayStruct([
                'js' => $js,
                'css' => $css,
            ])
        );
    }
}
