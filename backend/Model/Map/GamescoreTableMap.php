<?php

namespace Model\Map;

use Model\Gamescore;
use Model\GamescoreQuery;
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
 * This class defines the structure of the 'gamescore' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class GamescoreTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Map.GamescoreTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'gamescore';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Gamescore';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Gamescore';

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
    const COL_ID = 'gamescore.id';

    /**
     * the column name for the playerid field
     */
    const COL_PLAYERID = 'gamescore.playerid';

    /**
     * the column name for the gameid field
     */
    const COL_GAMEID = 'gamescore.gameid';

    /**
     * the column name for the ruleid field
     */
    const COL_RULEID = 'gamescore.ruleid';

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
        self::TYPE_PHPNAME       => array('Id', 'Playerid', 'Gameid', 'Ruleid', ),
        self::TYPE_CAMELNAME     => array('id', 'playerid', 'gameid', 'ruleid', ),
        self::TYPE_COLNAME       => array(GamescoreTableMap::COL_ID, GamescoreTableMap::COL_PLAYERID, GamescoreTableMap::COL_GAMEID, GamescoreTableMap::COL_RULEID, ),
        self::TYPE_FIELDNAME     => array('id', 'playerid', 'gameid', 'ruleid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Playerid' => 1, 'Gameid' => 2, 'Ruleid' => 3, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'playerid' => 1, 'gameid' => 2, 'ruleid' => 3, ),
        self::TYPE_COLNAME       => array(GamescoreTableMap::COL_ID => 0, GamescoreTableMap::COL_PLAYERID => 1, GamescoreTableMap::COL_GAMEID => 2, GamescoreTableMap::COL_RULEID => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'playerid' => 1, 'gameid' => 2, 'ruleid' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Gamescore.Id' => 'ID',
        'id' => 'ID',
        'gamescore.id' => 'ID',
        'GamescoreTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Playerid' => 'PLAYERID',
        'Gamescore.Playerid' => 'PLAYERID',
        'playerid' => 'PLAYERID',
        'gamescore.playerid' => 'PLAYERID',
        'GamescoreTableMap::COL_PLAYERID' => 'PLAYERID',
        'COL_PLAYERID' => 'PLAYERID',
        'Gameid' => 'GAMEID',
        'Gamescore.Gameid' => 'GAMEID',
        'gameid' => 'GAMEID',
        'gamescore.gameid' => 'GAMEID',
        'GamescoreTableMap::COL_GAMEID' => 'GAMEID',
        'COL_GAMEID' => 'GAMEID',
        'Ruleid' => 'RULEID',
        'Gamescore.Ruleid' => 'RULEID',
        'ruleid' => 'RULEID',
        'gamescore.ruleid' => 'RULEID',
        'GamescoreTableMap::COL_RULEID' => 'RULEID',
        'COL_RULEID' => 'RULEID',
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
        $this->setName('gamescore');
        $this->setPhpName('Gamescore');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Gamescore');
        $this->setPackage('Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('playerid', 'Playerid', 'INTEGER', 'player', 'id', false, null, null);
        $this->addForeignKey('gameid', 'Gameid', 'INTEGER', 'game', 'id', false, null, null);
        $this->addForeignKey('ruleid', 'Ruleid', 'INTEGER', 'rules', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Game', '\\Model\\Game', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':gameid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Player', '\\Model\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':playerid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Rules', '\\Model\\Rules', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ruleid',
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
        return $withPrefix ? GamescoreTableMap::CLASS_DEFAULT : GamescoreTableMap::OM_CLASS;
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
     * @return array           (Gamescore object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GamescoreTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GamescoreTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GamescoreTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GamescoreTableMap::OM_CLASS;
            /** @var Gamescore $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GamescoreTableMap::addInstanceToPool($obj, $key);
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
            $key = GamescoreTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GamescoreTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Gamescore $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GamescoreTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GamescoreTableMap::COL_ID);
            $criteria->addSelectColumn(GamescoreTableMap::COL_PLAYERID);
            $criteria->addSelectColumn(GamescoreTableMap::COL_GAMEID);
            $criteria->addSelectColumn(GamescoreTableMap::COL_RULEID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.playerid');
            $criteria->addSelectColumn($alias . '.gameid');
            $criteria->addSelectColumn($alias . '.ruleid');
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
            $criteria->removeSelectColumn(GamescoreTableMap::COL_ID);
            $criteria->removeSelectColumn(GamescoreTableMap::COL_PLAYERID);
            $criteria->removeSelectColumn(GamescoreTableMap::COL_GAMEID);
            $criteria->removeSelectColumn(GamescoreTableMap::COL_RULEID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.playerid');
            $criteria->removeSelectColumn($alias . '.gameid');
            $criteria->removeSelectColumn($alias . '.ruleid');
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
        return Propel::getServiceContainer()->getDatabaseMap(GamescoreTableMap::DATABASE_NAME)->getTable(GamescoreTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Gamescore or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Gamescore object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoreTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Gamescore) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GamescoreTableMap::DATABASE_NAME);
            $criteria->add(GamescoreTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GamescoreQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GamescoreTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GamescoreTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the gamescore table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GamescoreQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Gamescore or Criteria object.
     *
     * @param mixed               $criteria Criteria or Gamescore object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamescoreTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Gamescore object
        }


        // Set the correct dbName
        $query = GamescoreQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GamescoreTableMap
