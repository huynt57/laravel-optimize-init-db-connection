<?php

namespace Huynt57\LaravelOptimizeInitDbConnection;

use Illuminate\Database\Connectors\MySqlConnector;
use PDO;

class OptimizedMySqlConnector extends MySqlConnector
{
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);
        $options = $this->getOptions($config);
        // We need to grab the PDO options that should be used while making the brand
        // new connection instance. The PDO options control various aspects of the
        // connection's behavior, and some might be specified by the developers.
        $connection = $this->createConnection($dsn, $config, $options);

        if (!empty($config['database'])) {
            $connection->exec("use `{$config['database']}`;");
            $connection->exec("USE `{$config['database']}`;");
        }

        $this->configureIsolationLevel($connection, $config);

        $this->configureEncoding($connection, $config);

        // Next, we will check to see if a timezone has been specified in this config
        // and if it has we will issue a statement to modify the timezone with the
        // database. Setting this DB timezone is an optional configuration item.
        $this->configureTimezone($connection, $config);

        $this->setModes($connection, $config);
        $this->configureConnection($connection, $config);

        return $connection;
    }

    /**
     * Configure the connection.
     *
     * @param \PDO $connection
     * @param array $config
     * @return void
     */
    protected function configureConnection($connection, array $config): void
    {
        $statements = [];

        // First, we set the transaction isolation level.
        if (isset($config['isolation_level'])) {
            $statements[] = sprintf('SESSION TRANSACTION ISOLATION LEVEL %s', $config['isolation_level']);
        }

        // Now, we set the charset and possibly the collation.
        if (isset($config['charset'])) {
            if (isset($config['collation'])) {
                $statements[] = sprintf("NAMES '%s' COLLATE '%s'", $config['charset'], $config['collation']);
            } else {
                $statements[] = sprintf("NAMES '%s'", $config['charset']);
            }
        }

        // Next, we will check to see if a timezone has been specified in this config
        // and if it has we will issue a statement to modify the timezone with the
        // database. Setting this DB timezone is an optional configuration item.
        if (isset($config['timezone'])) {
            $statements[] = sprintf("time_zone='%s'", $config['timezone']);
        }

        // Next, we set the correct sql_mode mode according to the config.
        $sqlMode = $this->getSqlMode($connection, $config);
        if (null !== $sqlMode) {
            $statements[] = sprintf("SESSION sql_mode='%s'", $sqlMode);
        }

        // Finally, execute a single SET command with all our statements.
        if ([] !== $statements) {
            $connection->exec(sprintf('SET %s;', implode(', ', $statements)));
        }
    }

    /**
     * Get the sql_mode value.
     *
     * @param \PDO $connection
     * @param array $config
     * @return string|null
     */
    protected function getSqlMode($connection, $config)
    {
        if (isset($config['modes'])) {
            return implode(',', $config['modes']);
        }

        if (!isset($config['strict'])) {
            return null;
        }

        if (!$config['strict']) {
            return 'NO_ENGINE_SUBSTITUTION';
        }

        $version = $config['version'] ?? $connection->getAttribute(PDO::ATTR_SERVER_VERSION);

        if (version_compare($version, '8.0.11') >= 0) {
            return 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
        }

        return 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
    }


}
