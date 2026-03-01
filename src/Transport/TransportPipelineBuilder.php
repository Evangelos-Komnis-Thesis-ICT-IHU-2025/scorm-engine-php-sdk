<?php

declare(strict_types=1);

namespace ScormEngineSdk\Transport;

final class TransportPipelineBuilder
{
    /** @var array<int,TransportMiddlewareInterface> */
    private array $middlewares = [];

    public function addMiddleware(TransportMiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function build(TransportInterface $transport): TransportInterface
    {
        $resolved = $transport;

        foreach (array_reverse($this->middlewares) as $middleware) {
            $resolved = $middleware->wrap($resolved);
        }

        return $resolved;
    }
}
