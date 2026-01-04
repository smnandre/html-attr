<?php

namespace Symfony\UX\Html\Escaper;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
interface EscaperInterface
{
    public const STRATEGY_HTML = 'html';
    public const STRATEGY_HTML_ATTR = 'html_attr';
    public const STRATEGY_JS = 'js';
    public const STRATEGY_JSON = 'json';

    public function escape(string $value, string $strategy): string;
}
