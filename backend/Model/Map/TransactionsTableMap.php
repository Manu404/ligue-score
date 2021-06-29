<?php

namespace Model\Map;

use Model\Transactions;
use Model\TransactionsQuery;
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
 * This class defines the structure of the 'transactions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class TransactionsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Map.TransactionsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'transactions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Transactions';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Transactions';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'transactions.id';

    /**
     * the column name for the sourceid field
     */
    const COL_SOURCEID = 'transactions.sourceid';

    /**
     * the column name for the targetid field
     */
    const COL_TARGETID = 'transactions.targetid';

    /**
     * the column name for the delta field
     */
    const COL_DELTA = 'transactions.delta';

    /**
     * the column name for the gameid field
     */
    const COL_GAMEID = 'transactions.gameid';

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
        self::TYPE_PHPNAME       => array('Id', 'Sourceid', 'Targetid', 'Delta', 'Gameid', ),
        self::TYPE_CAMELNAME     => array('id', 'sourceid', 'targetid', 'delta', 'gameid', ),
        self::TYPE_COLNAME       => array(TransactionsTableMap::COL_ID, TransactionsTableMap::COL_SOURCEID, TransactionsTableMap::COL_TARGETID, TransactionsTableMap::COL_DELTA, TransactionsTableMap::COL_GAMEID, ),
        self::TYPE_FIELDNAME     => array('id', 'sourceid', 'targetid', 'delta', 'gameid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Sourceid' => 1, 'Targetid' => 2, 'Delta' => 3, 'Gameid' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'sourceid' => 1, 'targetid' => 2, 'delta' => 3, 'gameid' => 4, ),
        self::TYPE_COLNAME       => array(TransactionsTableMap::COL_ID => 0, TransactionsTableMap::COL_SOURCEID => 1, TransactionsTableMap::COL_TARGETID => 2, TransactionsTableMap::COL_DELTA => 3, TransactionsTableMap::COL_GAMEID => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'sourceid' => 1, 'targetid' => 2, 'delta' => 3, 'gameid' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Transactions.Id' => 'ID',
        'id' => 'ID',
        'transactions.id' => 'ID',
        'TransactionsTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Sourceid' => 'SOURCEID',
        'Transactions.Sourceid' => 'SOURCEID',
        'sourceid' => 'SOURCEID',
        'transactions.sourceid' => 'SOURCEID',
        'TransactionsTableMap::COL_SOURCEID' => 'SOURCEID',
        'COL_SOURCEID' => 'SOURCEID',
        'Targetid' => 'TARGETID',
        'Transactions.Targetid' => 'TARGETID',
        'targetid' => 'TARGETID',
        'transactions.targetid' => 'TARGETID',
        'TransactionsTableMap::COL_TARGETID' => 'TARGETID',
        'COL_TARGETID' => 'TARGETID',
        'Delta' => 'DELTA',
        'Transactions.Delta' => 'DELTA',
        'delta' => 'DELTA',
        'transactions.delta' => 'DELTA',
        'TransactionsTableMap::COL_DELTA' => 'DELTA',
        'COL_DELTA' => 'DELTA',
        'Gameid' => 'GAMEID',
        'Transactions.Gameid' => 'GAMEID',
        'gameid' => 'GAMEID',
        'transactions.gameid' => 'GAMEID',
        'TransactionsTableMap::COL_GAMEID' => 'GAMEID',
        'COL_GAMEID' => 'GAMEID',
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
        $this->setName('transactions');
        $this->setPhpName('Transactions');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Transactions');
        $this->setPackage('Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('sourceid', 'Sourceid', 'INTEGER', 'player', 'id', false, null, null);
        $this->addForeignKey('targetid', 'Targetid', 'INTEGER', 'player', 'id', false, null, null);
        $this->addColumn('delta', 'Delta', 'INTEGER', false, null, null);
        $this->addForeignKey('gameid', 'Gameid', 'INTEGER', 'game', 'id', false, null, null);
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
        $this->addRelation('PlayerRelatedBySourceid', '\\Model\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':sourceid',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PlayerRelatedByTargetid', '\\Model\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':targetid',
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
        return $withPrefix ? TransactionsTableMap::CLASS_DEFAULT : TransactionsTableMap::OM_CLASS;
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
     * @return array           (Transactions object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TransactionsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TransactionsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TransactionsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TransactionsTableMap::OM_CLASS;
            /** @var Transactions $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TransactionsTableMap::addInstanceToPool($obj, $key);
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
            $key = TransactionsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TransactionsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Transactions $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TransactionsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TransactionsTableMap::COL_ID);
            $criteria->addSelectColumn(TransactionsTableMap::COL_SOURCEID);
            $criteria->addSelectColumn(TransactionsTableMap::COL_TARGETID);
            $criteria->addSelectColumn(TransactionsTableMap::COL_DELTA);
            $criteria->addSelectColumn(TransactionsTableMap::COL_GAMEID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.sourceid');
            $criteria->addSelectColumn($alias . '.targetid');
            $criteria->addSelectColumn($alias . '.delta');
            $criteria->addSelectColumn($alias . '.gameid');
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
            $criteria->removeSelectColumn(TransactionsTableMap::COL_ID);
            $criteria->removeSelectColumn(TransactionsTableMap::COL_SOURCEID);
            $criteria->removeSelectColumn(TransactionsTableMap::COL_TARGETID);
            $criteria->removeSelectColumn(TransactionsTableMap::COL_DELTA);
            $criteria->removeSelectColumn(TransactionsTableMap::COL_GAMEID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.sourceid');
            $criteria->removeSelectColumn($alias . '.targetid');
            $criteria->removeSelectColumn($alias . '.delta');
            $criteria->removeSelectColumn($alias . '.gameid');
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
        return Propel::getServiceContainer()->getDatabaseMap(TransactionsTableMap::DATABASE_NAME)->getTable(TransactionsTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Transactions or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Transactions object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Transactions) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TransactionsTableMap::DATABASE_NAME);
            $criteria->add(TransactionsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TransactionsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TransactionsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TransactionsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the transactions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TransactionsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Transactions or Criteria object.
     *
     * @param mixed               $criteria Criteria or Transactions object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Transactions object
        }


        // Set the correct dbName
        $query = TransactionsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TransactionsTableMap
