<?php

namespace Tests\Wp;

require_once __DIR__ . '/../../../lib/class-msr-wp-plugin-logger.php';

use PHPUnit\Framework\TestCase;

class MSR_WP_WidgetTest extends TestCase
{
    public function testLoggerWorks()
    {
        $logger = \MsrWpLogger::instance();
        $result = $logger->info('info message', array('test'));
        $this->assertTrue($result);
    }
}
