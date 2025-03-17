<?php
/*
 * ProjectStatus.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi\Constants;

use ReflectionClass;

/**
 * Heizreport Project Status
 *
 */
class ProjectStatus
{
    const ARCHIVED = 5;
    const CREATED = 1;
    const IN_PROGRESS = 2;
    const READY = 3;
    public static function getName(int $statusId): ?string
    {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();
        $flipped = array_flip($constants); // Keys und Werte tauschen

        return $flipped[$statusId] ?? null;
    }
}
