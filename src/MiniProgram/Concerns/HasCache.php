<?php

namespace Zhineng\Bubble\MiniProgram\Concerns;

use Illuminate\Contracts\Cache\Repository;

trait HasCache
{
    protected Repository $cache;

    public function cacheUsing(Repository $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    public function cache(): Repository
    {
        return $this->cache;
    }

    public function hasCache(): bool
    {
        return isset($this->cache);
    }

    public function cacheKeyFor(string $item): string
    {
        return sprintf('bubble.mini_programs.%s.%s', $this->appId(), $item);
    }
}
