<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Game as ChildGame;
use Model\GameQuery as ChildGameQuery;
use Model\Gameday as ChildGameday;
use Model\GamedayQuery as ChildGamedayQuery;
use Model\Gameplayers as ChildGameplayers;
use Model\GameplayersQuery as ChildGameplayersQuery;
use Model\Gamescore as ChildGamescore;
use Model\GamescoreQuery as ChildGamescoreQuery;
use Model\PlayerBuy as ChildPlayerBuy;
use Model\PlayerBuyQuery as ChildPlayerBuyQuery;
use Model\Transactions as ChildTransactions;
use Model\TransactionsQuery as ChildTransactionsQuery;
use Model\Map\GameTableMap;
use Model\Map\GameplayersTableMap;
use Model\Map\GamescoreTableMap;
use Model\Map\PlayerBuyTableMap;
use Model\Map\TransactionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'game' table.
 *
 *
 *
 * @package    propel.generator.Model.Base
 */
abstract class Game implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Map\\GameTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the type field.
     *
     * @var        int|null
     */
    protected $type;

    /**
     * The value for the dayid field.
     *
     * @var        int|null
     */
    protected $dayid;

    /**
     * @var        ChildGameday
     */
    protected $aGameday;

    /**
     * @var        ObjectCollection|ChildGameplayers[] Collection to store aggregation of ChildGameplayers objects.
     */
    protected $collGameplayerss;
    protected $collGameplayerssPartial;

    /**
     * @var        ObjectCollection|ChildGamescore[] Collection to store aggregation of ChildGamescore objects.
     */
    protected $collGamescores;
    protected $collGamescoresPartial;

    /**
     * @var        ObjectCollection|ChildPlayerBuy[] Collection to store aggregation of ChildPlayerBuy objects.
     */
    protected $collPlayerBuys;
    protected $collPlayerBuysPartial;

    /**
     * @var        ObjectCollection|ChildTransactions[] Collection to store aggregation of ChildTransactions objects.
     */
    protected $collTransactionss;
    protected $collTransactionssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGameplayers[]
     */
    protected $gameplayerssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamescore[]
     */
    protected $gamescoresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayerBuy[]
     */
    protected $playerBuysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransactions[]
     */
    protected $transactionssScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Base\Game object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Game</code> instance.  If
     * <code>obj</code> is an instance of <code>Game</code>, delegates to
     * <code>equals(Game)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param  string  $keyType                (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [type] column value.
     *
     * @return int|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [dayid] column value.
     *
     * @return int|null
     */
    public function getDayid()
    {
        return $this->dayid;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GameTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [type] column.
     *
     * @param int|null $v New value
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[GameTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [dayid] column.
     *
     * @param int|null $v New value
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function setDayid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->dayid !== $v) {
            $this->dayid = $v;
            $this->modifiedColumns[GameTableMap::COL_DAYID] = true;
        }

        if ($this->aGameday !== null && $this->aGameday->getId() !== $v) {
            $this->aGameday = null;
        }

        return $this;
    } // setDayid()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GameTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GameTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GameTableMap::translateFieldName('Dayid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dayid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = GameTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Game'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aGameday !== null && $this->dayid !== $this->aGameday->getId()) {
            $this->aGameday = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGameQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGameday = null;
            $this->collGameplayerss = null;

            $this->collGamescores = null;

            $this->collPlayerBuys = null;

            $this->collTransactionss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Game::setDeleted()
     * @see Game::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGameQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GameTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aGameday !== null) {
                if ($this->aGameday->isModified() || $this->aGameday->isNew()) {
                    $affectedRows += $this->aGameday->save($con);
                }
                $this->setGameday($this->aGameday);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->gameplayerssScheduledForDeletion !== null) {
                if (!$this->gameplayerssScheduledForDeletion->isEmpty()) {
                    \Model\GameplayersQuery::create()
                        ->filterByPrimaryKeys($this->gameplayerssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gameplayerssScheduledForDeletion = null;
                }
            }

            if ($this->collGameplayerss !== null) {
                foreach ($this->collGameplayerss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gamescoresScheduledForDeletion !== null) {
                if (!$this->gamescoresScheduledForDeletion->isEmpty()) {
                    foreach ($this->gamescoresScheduledForDeletion as $gamescore) {
                        // need to save related object because we set the relation to null
                        $gamescore->save($con);
                    }
                    $this->gamescoresScheduledForDeletion = null;
                }
            }

            if ($this->collGamescores !== null) {
                foreach ($this->collGamescores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->playerBuysScheduledForDeletion !== null) {
                if (!$this->playerBuysScheduledForDeletion->isEmpty()) {
                    foreach ($this->playerBuysScheduledForDeletion as $playerBuy) {
                        // need to save related object because we set the relation to null
                        $playerBuy->save($con);
                    }
                    $this->playerBuysScheduledForDeletion = null;
                }
            }

            if ($this->collPlayerBuys !== null) {
                foreach ($this->collPlayerBuys as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionssScheduledForDeletion !== null) {
                if (!$this->transactionssScheduledForDeletion->isEmpty()) {
                    foreach ($this->transactionssScheduledForDeletion as $transactions) {
                        // need to save related object because we set the relation to null
                        $transactions->save($con);
                    }
                    $this->transactionssScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionss !== null) {
                foreach ($this->collTransactionss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[GameTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GameTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GameTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GameTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(GameTableMap::COL_DAYID)) {
            $modifiedColumns[':p' . $index++]  = 'dayid';
        }

        $sql = sprintf(
            'INSERT INTO game (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case 'dayid':
                        $stmt->bindValue($identifier, $this->dayid, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getType();
                break;
            case 2:
                return $this->getDayid();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Game'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Game'][$this->hashCode()] = true;
        $keys = GameTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getDayid(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aGameday) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameday';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gameday';
                        break;
                    default:
                        $key = 'Gameday';
                }

                $result[$key] = $this->aGameday->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collGameplayerss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameplayerss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gameplayerss';
                        break;
                    default:
                        $key = 'Gameplayerss';
                }

                $result[$key] = $this->collGameplayerss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGamescores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamescores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gamescores';
                        break;
                    default:
                        $key = 'Gamescores';
                }

                $result[$key] = $this->collGamescores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPlayerBuys) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerBuys';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_buys';
                        break;
                    default:
                        $key = 'PlayerBuys';
                }

                $result[$key] = $this->collPlayerBuys->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transactionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transactionss';
                        break;
                    default:
                        $key = 'Transactionss';
                }

                $result[$key] = $this->collTransactionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Model\Game
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Game
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setType($value);
                break;
            case 2:
                $this->setDayid($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     $this|\Model\Game
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GameTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDayid($arr[$keys[2]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Model\Game The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GameTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GameTableMap::COL_ID)) {
            $criteria->add(GameTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GameTableMap::COL_TYPE)) {
            $criteria->add(GameTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(GameTableMap::COL_DAYID)) {
            $criteria->add(GameTableMap::COL_DAYID, $this->dayid);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGameQuery::create();
        $criteria->add(GameTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Game (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setType($this->getType());
        $copyObj->setDayid($this->getDayid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGameplayerss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGameplayers($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGamescores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGamescore($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlayerBuys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerBuy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactions($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Model\Game Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildGameday object.
     *
     * @param  ChildGameday|null $v
     * @return $this|\Model\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGameday(ChildGameday $v = null)
    {
        if ($v === null) {
            $this->setDayid(NULL);
        } else {
            $this->setDayid($v->getId());
        }

        $this->aGameday = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGameday object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGameday object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGameday|null The associated ChildGameday object.
     * @throws PropelException
     */
    public function getGameday(ConnectionInterface $con = null)
    {
        if ($this->aGameday === null && ($this->dayid != 0)) {
            $this->aGameday = ChildGamedayQuery::create()->findPk($this->dayid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGameday->addGames($this);
             */
        }

        return $this->aGameday;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Gameplayers' === $relationName) {
            $this->initGameplayerss();
            return;
        }
        if ('Gamescore' === $relationName) {
            $this->initGamescores();
            return;
        }
        if ('PlayerBuy' === $relationName) {
            $this->initPlayerBuys();
            return;
        }
        if ('Transactions' === $relationName) {
            $this->initTransactionss();
            return;
        }
    }

    /**
     * Clears out the collGameplayerss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGameplayerss()
     */
    public function clearGameplayerss()
    {
        $this->collGameplayerss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGameplayerss collection loaded partially.
     */
    public function resetPartialGameplayerss($v = true)
    {
        $this->collGameplayerssPartial = $v;
    }

    /**
     * Initializes the collGameplayerss collection.
     *
     * By default this just sets the collGameplayerss collection to an empty array (like clearcollGameplayerss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGameplayerss($overrideExisting = true)
    {
        if (null !== $this->collGameplayerss && !$overrideExisting) {
            return;
        }

        $collectionClassName = GameplayersTableMap::getTableMap()->getCollectionClassName();

        $this->collGameplayerss = new $collectionClassName;
        $this->collGameplayerss->setModel('\Model\Gameplayers');
    }

    /**
     * Gets an array of ChildGameplayers objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGameplayers[] List of ChildGameplayers objects
     * @throws PropelException
     */
    public function getGameplayerss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGameplayerssPartial && !$this->isNew();
        if (null === $this->collGameplayerss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGameplayerss) {
                    $this->initGameplayerss();
                } else {
                    $collectionClassName = GameplayersTableMap::getTableMap()->getCollectionClassName();

                    $collGameplayerss = new $collectionClassName;
                    $collGameplayerss->setModel('\Model\Gameplayers');

                    return $collGameplayerss;
                }
            } else {
                $collGameplayerss = ChildGameplayersQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGameplayerssPartial && count($collGameplayerss)) {
                        $this->initGameplayerss(false);

                        foreach ($collGameplayerss as $obj) {
                            if (false == $this->collGameplayerss->contains($obj)) {
                                $this->collGameplayerss->append($obj);
                            }
                        }

                        $this->collGameplayerssPartial = true;
                    }

                    return $collGameplayerss;
                }

                if ($partial && $this->collGameplayerss) {
                    foreach ($this->collGameplayerss as $obj) {
                        if ($obj->isNew()) {
                            $collGameplayerss[] = $obj;
                        }
                    }
                }

                $this->collGameplayerss = $collGameplayerss;
                $this->collGameplayerssPartial = false;
            }
        }

        return $this->collGameplayerss;
    }

    /**
     * Sets a collection of ChildGameplayers objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gameplayerss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setGameplayerss(Collection $gameplayerss, ConnectionInterface $con = null)
    {
        /** @var ChildGameplayers[] $gameplayerssToDelete */
        $gameplayerssToDelete = $this->getGameplayerss(new Criteria(), $con)->diff($gameplayerss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->gameplayerssScheduledForDeletion = clone $gameplayerssToDelete;

        foreach ($gameplayerssToDelete as $gameplayersRemoved) {
            $gameplayersRemoved->setGame(null);
        }

        $this->collGameplayerss = null;
        foreach ($gameplayerss as $gameplayers) {
            $this->addGameplayers($gameplayers);
        }

        $this->collGameplayerss = $gameplayerss;
        $this->collGameplayerssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gameplayers objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gameplayers objects.
     * @throws PropelException
     */
    public function countGameplayerss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGameplayerssPartial && !$this->isNew();
        if (null === $this->collGameplayerss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGameplayerss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGameplayerss());
            }

            $query = ChildGameplayersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collGameplayerss);
    }

    /**
     * Method called to associate a ChildGameplayers object to this object
     * through the ChildGameplayers foreign key attribute.
     *
     * @param  ChildGameplayers $l ChildGameplayers
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function addGameplayers(ChildGameplayers $l)
    {
        if ($this->collGameplayerss === null) {
            $this->initGameplayerss();
            $this->collGameplayerssPartial = true;
        }

        if (!$this->collGameplayerss->contains($l)) {
            $this->doAddGameplayers($l);

            if ($this->gameplayerssScheduledForDeletion and $this->gameplayerssScheduledForDeletion->contains($l)) {
                $this->gameplayerssScheduledForDeletion->remove($this->gameplayerssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGameplayers $gameplayers The ChildGameplayers object to add.
     */
    protected function doAddGameplayers(ChildGameplayers $gameplayers)
    {
        $this->collGameplayerss[]= $gameplayers;
        $gameplayers->setGame($this);
    }

    /**
     * @param  ChildGameplayers $gameplayers The ChildGameplayers object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeGameplayers(ChildGameplayers $gameplayers)
    {
        if ($this->getGameplayerss()->contains($gameplayers)) {
            $pos = $this->collGameplayerss->search($gameplayers);
            $this->collGameplayerss->remove($pos);
            if (null === $this->gameplayerssScheduledForDeletion) {
                $this->gameplayerssScheduledForDeletion = clone $this->collGameplayerss;
                $this->gameplayerssScheduledForDeletion->clear();
            }
            $this->gameplayerssScheduledForDeletion[]= clone $gameplayers;
            $gameplayers->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Gameplayerss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameplayers[] List of ChildGameplayers objects
     */
    public function getGameplayerssJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameplayersQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getGameplayerss($query, $con);
    }

    /**
     * Clears out the collGamescores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamescores()
     */
    public function clearGamescores()
    {
        $this->collGamescores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGamescores collection loaded partially.
     */
    public function resetPartialGamescores($v = true)
    {
        $this->collGamescoresPartial = $v;
    }

    /**
     * Initializes the collGamescores collection.
     *
     * By default this just sets the collGamescores collection to an empty array (like clearcollGamescores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamescores($overrideExisting = true)
    {
        if (null !== $this->collGamescores && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamescoreTableMap::getTableMap()->getCollectionClassName();

        $this->collGamescores = new $collectionClassName;
        $this->collGamescores->setModel('\Model\Gamescore');
    }

    /**
     * Gets an array of ChildGamescore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamescore[] List of ChildGamescore objects
     * @throws PropelException
     */
    public function getGamescores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamescoresPartial && !$this->isNew();
        if (null === $this->collGamescores || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGamescores) {
                    $this->initGamescores();
                } else {
                    $collectionClassName = GamescoreTableMap::getTableMap()->getCollectionClassName();

                    $collGamescores = new $collectionClassName;
                    $collGamescores->setModel('\Model\Gamescore');

                    return $collGamescores;
                }
            } else {
                $collGamescores = ChildGamescoreQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamescoresPartial && count($collGamescores)) {
                        $this->initGamescores(false);

                        foreach ($collGamescores as $obj) {
                            if (false == $this->collGamescores->contains($obj)) {
                                $this->collGamescores->append($obj);
                            }
                        }

                        $this->collGamescoresPartial = true;
                    }

                    return $collGamescores;
                }

                if ($partial && $this->collGamescores) {
                    foreach ($this->collGamescores as $obj) {
                        if ($obj->isNew()) {
                            $collGamescores[] = $obj;
                        }
                    }
                }

                $this->collGamescores = $collGamescores;
                $this->collGamescoresPartial = false;
            }
        }

        return $this->collGamescores;
    }

    /**
     * Sets a collection of ChildGamescore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gamescores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setGamescores(Collection $gamescores, ConnectionInterface $con = null)
    {
        /** @var ChildGamescore[] $gamescoresToDelete */
        $gamescoresToDelete = $this->getGamescores(new Criteria(), $con)->diff($gamescores);


        $this->gamescoresScheduledForDeletion = $gamescoresToDelete;

        foreach ($gamescoresToDelete as $gamescoreRemoved) {
            $gamescoreRemoved->setGame(null);
        }

        $this->collGamescores = null;
        foreach ($gamescores as $gamescore) {
            $this->addGamescore($gamescore);
        }

        $this->collGamescores = $gamescores;
        $this->collGamescoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gamescore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gamescore objects.
     * @throws PropelException
     */
    public function countGamescores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamescoresPartial && !$this->isNew();
        if (null === $this->collGamescores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamescores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGamescores());
            }

            $query = ChildGamescoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collGamescores);
    }

    /**
     * Method called to associate a ChildGamescore object to this object
     * through the ChildGamescore foreign key attribute.
     *
     * @param  ChildGamescore $l ChildGamescore
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function addGamescore(ChildGamescore $l)
    {
        if ($this->collGamescores === null) {
            $this->initGamescores();
            $this->collGamescoresPartial = true;
        }

        if (!$this->collGamescores->contains($l)) {
            $this->doAddGamescore($l);

            if ($this->gamescoresScheduledForDeletion and $this->gamescoresScheduledForDeletion->contains($l)) {
                $this->gamescoresScheduledForDeletion->remove($this->gamescoresScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamescore $gamescore The ChildGamescore object to add.
     */
    protected function doAddGamescore(ChildGamescore $gamescore)
    {
        $this->collGamescores[]= $gamescore;
        $gamescore->setGame($this);
    }

    /**
     * @param  ChildGamescore $gamescore The ChildGamescore object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeGamescore(ChildGamescore $gamescore)
    {
        if ($this->getGamescores()->contains($gamescore)) {
            $pos = $this->collGamescores->search($gamescore);
            $this->collGamescores->remove($pos);
            if (null === $this->gamescoresScheduledForDeletion) {
                $this->gamescoresScheduledForDeletion = clone $this->collGamescores;
                $this->gamescoresScheduledForDeletion->clear();
            }
            $this->gamescoresScheduledForDeletion[]= $gamescore;
            $gamescore->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Gamescores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamescore[] List of ChildGamescore objects
     */
    public function getGamescoresJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamescoreQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getGamescores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Gamescores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamescore[] List of ChildGamescore objects
     */
    public function getGamescoresJoinRules(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamescoreQuery::create(null, $criteria);
        $query->joinWith('Rules', $joinBehavior);

        return $this->getGamescores($query, $con);
    }

    /**
     * Clears out the collPlayerBuys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayerBuys()
     */
    public function clearPlayerBuys()
    {
        $this->collPlayerBuys = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayerBuys collection loaded partially.
     */
    public function resetPartialPlayerBuys($v = true)
    {
        $this->collPlayerBuysPartial = $v;
    }

    /**
     * Initializes the collPlayerBuys collection.
     *
     * By default this just sets the collPlayerBuys collection to an empty array (like clearcollPlayerBuys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayerBuys($overrideExisting = true)
    {
        if (null !== $this->collPlayerBuys && !$overrideExisting) {
            return;
        }

        $collectionClassName = PlayerBuyTableMap::getTableMap()->getCollectionClassName();

        $this->collPlayerBuys = new $collectionClassName;
        $this->collPlayerBuys->setModel('\Model\PlayerBuy');
    }

    /**
     * Gets an array of ChildPlayerBuy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayerBuy[] List of ChildPlayerBuy objects
     * @throws PropelException
     */
    public function getPlayerBuys(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerBuysPartial && !$this->isNew();
        if (null === $this->collPlayerBuys || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPlayerBuys) {
                    $this->initPlayerBuys();
                } else {
                    $collectionClassName = PlayerBuyTableMap::getTableMap()->getCollectionClassName();

                    $collPlayerBuys = new $collectionClassName;
                    $collPlayerBuys->setModel('\Model\PlayerBuy');

                    return $collPlayerBuys;
                }
            } else {
                $collPlayerBuys = ChildPlayerBuyQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayerBuysPartial && count($collPlayerBuys)) {
                        $this->initPlayerBuys(false);

                        foreach ($collPlayerBuys as $obj) {
                            if (false == $this->collPlayerBuys->contains($obj)) {
                                $this->collPlayerBuys->append($obj);
                            }
                        }

                        $this->collPlayerBuysPartial = true;
                    }

                    return $collPlayerBuys;
                }

                if ($partial && $this->collPlayerBuys) {
                    foreach ($this->collPlayerBuys as $obj) {
                        if ($obj->isNew()) {
                            $collPlayerBuys[] = $obj;
                        }
                    }
                }

                $this->collPlayerBuys = $collPlayerBuys;
                $this->collPlayerBuysPartial = false;
            }
        }

        return $this->collPlayerBuys;
    }

    /**
     * Sets a collection of ChildPlayerBuy objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $playerBuys A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setPlayerBuys(Collection $playerBuys, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerBuy[] $playerBuysToDelete */
        $playerBuysToDelete = $this->getPlayerBuys(new Criteria(), $con)->diff($playerBuys);


        $this->playerBuysScheduledForDeletion = $playerBuysToDelete;

        foreach ($playerBuysToDelete as $playerBuyRemoved) {
            $playerBuyRemoved->setGame(null);
        }

        $this->collPlayerBuys = null;
        foreach ($playerBuys as $playerBuy) {
            $this->addPlayerBuy($playerBuy);
        }

        $this->collPlayerBuys = $playerBuys;
        $this->collPlayerBuysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlayerBuy objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlayerBuy objects.
     * @throws PropelException
     */
    public function countPlayerBuys(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerBuysPartial && !$this->isNew();
        if (null === $this->collPlayerBuys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayerBuys) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayerBuys());
            }

            $query = ChildPlayerBuyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collPlayerBuys);
    }

    /**
     * Method called to associate a ChildPlayerBuy object to this object
     * through the ChildPlayerBuy foreign key attribute.
     *
     * @param  ChildPlayerBuy $l ChildPlayerBuy
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function addPlayerBuy(ChildPlayerBuy $l)
    {
        if ($this->collPlayerBuys === null) {
            $this->initPlayerBuys();
            $this->collPlayerBuysPartial = true;
        }

        if (!$this->collPlayerBuys->contains($l)) {
            $this->doAddPlayerBuy($l);

            if ($this->playerBuysScheduledForDeletion and $this->playerBuysScheduledForDeletion->contains($l)) {
                $this->playerBuysScheduledForDeletion->remove($this->playerBuysScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPlayerBuy $playerBuy The ChildPlayerBuy object to add.
     */
    protected function doAddPlayerBuy(ChildPlayerBuy $playerBuy)
    {
        $this->collPlayerBuys[]= $playerBuy;
        $playerBuy->setGame($this);
    }

    /**
     * @param  ChildPlayerBuy $playerBuy The ChildPlayerBuy object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removePlayerBuy(ChildPlayerBuy $playerBuy)
    {
        if ($this->getPlayerBuys()->contains($playerBuy)) {
            $pos = $this->collPlayerBuys->search($playerBuy);
            $this->collPlayerBuys->remove($pos);
            if (null === $this->playerBuysScheduledForDeletion) {
                $this->playerBuysScheduledForDeletion = clone $this->collPlayerBuys;
                $this->playerBuysScheduledForDeletion->clear();
            }
            $this->playerBuysScheduledForDeletion[]= $playerBuy;
            $playerBuy->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related PlayerBuys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerBuy[] List of ChildPlayerBuy objects
     */
    public function getPlayerBuysJoinShopitems(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerBuyQuery::create(null, $criteria);
        $query->joinWith('Shopitems', $joinBehavior);

        return $this->getPlayerBuys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related PlayerBuys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerBuy[] List of ChildPlayerBuy objects
     */
    public function getPlayerBuysJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerBuyQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getPlayerBuys($query, $con);
    }

    /**
     * Clears out the collTransactionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionss()
     */
    public function clearTransactionss()
    {
        $this->collTransactionss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionss collection loaded partially.
     */
    public function resetPartialTransactionss($v = true)
    {
        $this->collTransactionssPartial = $v;
    }

    /**
     * Initializes the collTransactionss collection.
     *
     * By default this just sets the collTransactionss collection to an empty array (like clearcollTransactionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionss($overrideExisting = true)
    {
        if (null !== $this->collTransactionss && !$overrideExisting) {
            return;
        }

        $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

        $this->collTransactionss = new $collectionClassName;
        $this->collTransactionss->setModel('\Model\Transactions');
    }

    /**
     * Gets an array of ChildTransactions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     * @throws PropelException
     */
    public function getTransactionss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssPartial && !$this->isNew();
        if (null === $this->collTransactionss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTransactionss) {
                    $this->initTransactionss();
                } else {
                    $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

                    $collTransactionss = new $collectionClassName;
                    $collTransactionss->setModel('\Model\Transactions');

                    return $collTransactionss;
                }
            } else {
                $collTransactionss = ChildTransactionsQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionssPartial && count($collTransactionss)) {
                        $this->initTransactionss(false);

                        foreach ($collTransactionss as $obj) {
                            if (false == $this->collTransactionss->contains($obj)) {
                                $this->collTransactionss->append($obj);
                            }
                        }

                        $this->collTransactionssPartial = true;
                    }

                    return $collTransactionss;
                }

                if ($partial && $this->collTransactionss) {
                    foreach ($this->collTransactionss as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionss[] = $obj;
                        }
                    }
                }

                $this->collTransactionss = $collTransactionss;
                $this->collTransactionssPartial = false;
            }
        }

        return $this->collTransactionss;
    }

    /**
     * Sets a collection of ChildTransactions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setTransactionss(Collection $transactionss, ConnectionInterface $con = null)
    {
        /** @var ChildTransactions[] $transactionssToDelete */
        $transactionssToDelete = $this->getTransactionss(new Criteria(), $con)->diff($transactionss);


        $this->transactionssScheduledForDeletion = $transactionssToDelete;

        foreach ($transactionssToDelete as $transactionsRemoved) {
            $transactionsRemoved->setGame(null);
        }

        $this->collTransactionss = null;
        foreach ($transactionss as $transactions) {
            $this->addTransactions($transactions);
        }

        $this->collTransactionss = $transactionss;
        $this->collTransactionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transactions objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transactions objects.
     * @throws PropelException
     */
    public function countTransactionss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssPartial && !$this->isNew();
        if (null === $this->collTransactionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionss());
            }

            $query = ChildTransactionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collTransactionss);
    }

    /**
     * Method called to associate a ChildTransactions object to this object
     * through the ChildTransactions foreign key attribute.
     *
     * @param  ChildTransactions $l ChildTransactions
     * @return $this|\Model\Game The current object (for fluent API support)
     */
    public function addTransactions(ChildTransactions $l)
    {
        if ($this->collTransactionss === null) {
            $this->initTransactionss();
            $this->collTransactionssPartial = true;
        }

        if (!$this->collTransactionss->contains($l)) {
            $this->doAddTransactions($l);

            if ($this->transactionssScheduledForDeletion and $this->transactionssScheduledForDeletion->contains($l)) {
                $this->transactionssScheduledForDeletion->remove($this->transactionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTransactions $transactions The ChildTransactions object to add.
     */
    protected function doAddTransactions(ChildTransactions $transactions)
    {
        $this->collTransactionss[]= $transactions;
        $transactions->setGame($this);
    }

    /**
     * @param  ChildTransactions $transactions The ChildTransactions object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeTransactions(ChildTransactions $transactions)
    {
        if ($this->getTransactionss()->contains($transactions)) {
            $pos = $this->collTransactionss->search($transactions);
            $this->collTransactionss->remove($pos);
            if (null === $this->transactionssScheduledForDeletion) {
                $this->transactionssScheduledForDeletion = clone $this->collTransactionss;
                $this->transactionssScheduledForDeletion->clear();
            }
            $this->transactionssScheduledForDeletion[]= $transactions;
            $transactions->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Transactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     */
    public function getTransactionssJoinPlayerRelatedBySourceid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionsQuery::create(null, $criteria);
        $query->joinWith('PlayerRelatedBySourceid', $joinBehavior);

        return $this->getTransactionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Transactionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     */
    public function getTransactionssJoinPlayerRelatedByTargetid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionsQuery::create(null, $criteria);
        $query->joinWith('PlayerRelatedByTargetid', $joinBehavior);

        return $this->getTransactionss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aGameday) {
            $this->aGameday->removeGame($this);
        }
        $this->id = null;
        $this->type = null;
        $this->dayid = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collGameplayerss) {
                foreach ($this->collGameplayerss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGamescores) {
                foreach ($this->collGamescores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlayerBuys) {
                foreach ($this->collPlayerBuys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionss) {
                foreach ($this->collTransactionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGameplayerss = null;
        $this->collGamescores = null;
        $this->collPlayerBuys = null;
        $this->collTransactionss = null;
        $this->aGameday = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GameTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
