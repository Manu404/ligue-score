<?php

namespace Model\Map;

use Model\Gamedayruleset;
use Model\GamedayrulesetQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'gamedayruleset' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class GamedayrulesetTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Map.GamedayrulesetTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'gamedayruleset';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Gamedayruleset';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Gamedayruleset';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the id field
     */
    const COL_ID = 'gamedayruleset.id';

    /**
     * the column name for the rulesetid field
     */
    const COL_RULESETID = 'gamedayruleset.rulesetid';

    /**
     * the column name for the dayid field
     */
    const COL_DAYID = 'gamedayruleset.dayid';

    /**
     * the column name for the gametypeid field
     */
    const COL_GAMETYPEID = 'gamedayruleset.gametypeid';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Rulesetid', 'Dayid', 'Gametypeid', ),
        self::TYPE_CAMELNAME     => array('id', 'rulesetid', 'dayid', 'gametypeid', ),
        self::TYPE_COLNAME       => array(GamedayrulesetTableMap::COL_ID, GamedayrulesetTableMap::COL_RULESETID, GamedayrulesetTableMap::COL_DAYID, GamedayrulesetTableMap::COL_GAMETYPEID, ),
        self::TYPE_FIELDNAME     => array('id', 'rulesetid', 'dayid', 'gametypeid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Rulesetid' => 1, 'Dayid' => 2, 'Gametypeid' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'rulesetid' => 1, 'dayid' => 2, 'gametypeid' => 3, ),
        self::TYPE_COLNAME       => array(GamedayrulesetTableMap::COL_ID => 0, GamedayrulesetTableMap::COL_RULESETID => 1, GamedayrulesetTableMap::COL_DAYID => 2, GamedayrulesetTableMap::COL_GAMETYPEID => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'rulesetid' => 1, 'dayid' => 2, 'gametypeid' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Gamedayruleset.Id' => 'ID',
        'id' => 'ID',
        'gamedayruleset.id' => 'ID',
        'GamedayrulesetTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Rulesetid' => 'RULESETID',
        'Gamedayruleset.Rulesetid' => 'RULESETID',
        'rulesetid' => 'RULESETID',
        'gamedayruleset.rulesetid' => 'RULESETID',
        'GamedayrulesetTableMap::COL_RULESETID' => 'RULESETID',
        'COL_RULESETID' => 'RULESETID',
        'Dayid' => 'DAYID',
        'Gamedayruleset.Dayid' => 'DAYID',
        'dayid' => 'DAYID',
        'gamedayruleset.dayid' => 'DAYID',
        'GamedayrulesetTableMap::COL_DAYID' => 'DAYID',
        'COL_DAYID' => 'DAYID',
        'Gametypeid' => 'GAMETYPEID',
        'Gamedayruleset.Gametypeid' => 'GAMETYPEID',
        'gametypeid' => 'GAMETYPEID',
        'gamedayruleset.gametypeid' => 'GAMETYPEID',
        'GamedayrulesetTableMap::COL_GAMETYPEID' => 'GAMETYPEID',
        'COL_GAMETYPEID' => 'GAMETYPEID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('gamedayruleset');
        $this->setPhpName('Gamedayruleset');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Gamedayruleset');
        $this->setPackage('Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('rulesetid', 'Rulesetid', 'INTEGER', 'ruleset', 'id', false, null, null);
        $this->addForeignKey('dayid', 'Dayid', 'INTEGER', 'gameday', 'id', false, null, null);
        $this->addForeignKey('gametypeid', 'Gametypeid', 'INTEGER', 'gametype', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Gameday', '\\Model\\Gameday', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':dayid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Ruleset', '\\Model\\Ruleset', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':rulesetid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Gametype', '\\Model\\Gametype', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':gametypeid',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? GamedayrulesetTableMap::CLASS_DEFAULT : GamedayrulesetTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Gamedayruleset object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GamedayrulesetTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GamedayrulesetTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GamedayrulesetTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GamedayrulesetTableMap::OM_CLASS;
            /** @var Gamedayruleset $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GamedayrulesetTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = GamedayrulesetTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GamedayrulesetTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Gamedayruleset $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GamedayrulesetTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(GamedayrulesetTableMap::COL_ID);
            $criteria->addSelectColumn(GamedayrulesetTableMap::COL_RULESETID);
            $criteria->addSelectColumn(GamedayrulesetTableMap::COL_DAYID);
            $criteria->addSelectColumn(GamedayrulesetTableMap::COL_GAMETYPEID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.rulesetid');
            $criteria->addSelectColumn($alias . '.dayid');
            $criteria->addSelectColumn($alias . '.gametypeid');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(GamedayrulesetTableMap::COL_ID);
            $criteria->removeSelectColumn(GamedayrulesetTableMap::COL_RULESETID);
            $criteria->removeSelectColumn(GamedayrulesetTableMap::COL_DAYID);
            $criteria->removeSelectColumn(GamedayrulesetTableMap::COL_GAMETYPEID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.rulesetid');
            $criteria->removeSelectColumn($alias . '.dayid');
            $criteria->removeSelectColumn($alias . '.gametypeid');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(GamedayrulesetTableMap::DATABASE_NAME)->getTable(GamedayrulesetTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Gamedayruleset or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Gamedayruleset object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayrulesetTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Gamedayruleset) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GamedayrulesetTableMap::DATABASE_NAME);
            $criteria->add(GamedayrulesetTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GamedayrulesetQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GamedayrulesetTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GamedayrulesetTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the gamedayruleset table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GamedayrulesetQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Gamedayruleset or Criteria object.
     *
     * @param mixed               $criteria Criteria or Gamedayruleset object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayrulesetTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Gamedayruleset object
        }


        // Set the correct dbName
        $query = GamedayrulesetQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GamedayrulesetTableMap
