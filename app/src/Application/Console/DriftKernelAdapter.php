<?php

/*
 * This file is part of the React Symfony Server package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Application\Console;

use Drift\HttpKernel\AsyncKernel;
use App\Kernel as ApplicationKernel;
use Drift\Server\Adapter\KernelAdapter;

/**
 * Class DriftKernelAdapter.
 */
class DriftKernelAdapter implements KernelAdapter
{
    /**
     * Build AsyncKernel.
     */
    public static function buildKernel(
        string $environment,
        bool $debug
    ): AsyncKernel {
        return new ApplicationKernel($environment, $debug);
    }

    /**
     * Get static folder by kernel.
     *
     * @param AsyncKernel $kernel
     *
     * @return string|null
     */
    public static function getStaticFolder(AsyncKernel $kernel): ? string
    {
        return '/public';
    }
}
