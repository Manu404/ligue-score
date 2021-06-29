<?php

use Propel\Generator\Model\Column;
use Propel\Generator\Model\Database;
use Propel\Generator\Model\ForeignKey;
use Propel\Generator\Model\Index;
use Propel\Generator\Model\Table;
use Propel\Generator\Model\Unique;
use Propel\Generator\Model\PropelTypes;
use Propel\Generator\Model\ColumnDefaultValue;

class MyCustomMysqlSchemaParser extends \Propel\Generator\Reverse\MysqlSchemaParser
{

    // Mostly copy-pasted from parent class, except as mentioned in comments below
    protected function parseTables(Database $database, $filterTable = null)
    {
        $sql = 'SHOW FULL TABLES';

        if ($filterTable) {
            if ($schema = $filterTable->getSchema()) {
                $sql .= ' FROM ' . $database->getPlatform()->doQuoting($schema);
            }
            $sql .= sprintf(" LIKE '%s'", $filterTable->getCommonName());
        } else if ($schema = $database->getSchema()) {
            $sql .= ' FROM ' . $database->getPlatform()->doQuoting($schema);
        }

        $dataFetcher = $this->dbh->query($sql);

        // First load the tables (important that this happen before filling out details of tables)
        $tables = [];
        foreach ($dataFetcher as $row) {
            $name = $row[0];
            $type = $row[1];

            // Line changed to include views in reverse-engineered schema.xml (https://github.com/propelorm/Propel/issues/458)
            if ($name == $this->getMigrationTable() || !in_array($type, array("BASE TABLE", "VIEW"))) {
                continue;
            }

            $table = new Table($name);
            $table->setIdMethod($database->getDefaultIdMethod());
            if ($filterTable && $filterTable->getSchema()) {
                $table->setSchema($filterTable->getSchema());
            }
            $database->addTable($table);
            $tables[] = $table;
        }
    }

}