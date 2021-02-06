<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\Singleton;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\Storage\Redis;

class Metrics extends Singleton
{
    private const METRIC_HEALTH_CHECK_PREFIX = 'healthcheck_';
    /**
     * @var CollectorRegistry
     */
    private $registry;
    
    public function __construct()
    {
        Redis::setDefaultOptions(
            [
                'host' => '127.0.0.1',
                'port' => 6379,
                'password' => null,
                'timeout' => 0.1, // in seconds
                'read_timeout' => '10', // in seconds
                'persistent_connections' => false
            ]
        );
        $this->registry = CollectorRegistry::getDefault();
    }
    
    /**
     * @return CollectorRegistry
     */
    public function getRegistry(): CollectorRegistry
    {
        return $this->registry;
    }
    
    /**
     * @param string $metricName
     *
     * @throws MetricsRegistrationException
     */
    public function increaseMetric(string $metricName): void
    {
        $counter = $this->registry->getOrRegisterCounter('asterios_bot', $metricName, 'it increases');
        $counter->incBy(1, []);
    }
    
    /**
     * @param string $serverName
     *
     * @throws MetricsRegistrationException
     */
    public function increaseHealthCheck(string $serverName): void
    {
        $this->increaseMetric(self::METRIC_HEALTH_CHECK_PREFIX . $serverName);
    }
}
