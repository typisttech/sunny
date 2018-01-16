<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Decorators\Fields;

use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Factories\ViewFactory;
use TypistTech\Sunny\Vendor\TypistTech\WPBetterSettings\Views\ViewInterface;

/**
 * Final class Textarea
 *
 * This class defines necessary methods for rendering `src/partials/fields/textarea.php`.
 */
final class Textarea extends AbstractField
{
    /**
     * Number of rows
     *
     * @var int
     */
    private $rows = 0;

    /**
     * Rows getter.
     *
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * Rows setter.
     *
     * @param int $rows Number of rows.
     *
     * @return void
     */
    public function setRows(int $rows)
    {
        $this->rows = $rows;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): ViewInterface
    {
        return ViewFactory::build('fields/textarea');
    }
}
