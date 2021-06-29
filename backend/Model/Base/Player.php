<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Gameplayers as ChildGameplayers;
use Model\GameplayersQuery as ChildGameplayersQuery;
use Model\Gamescore as ChildGamescore;
use Model\GamescoreQuery as ChildGamescoreQuery;
use Model\Player as ChildPlayer;
use Model\PlayerBuy as ChildPlayerBuy;
use Model\PlayerBuyQuery as ChildPlayerBuyQuery;
use Model\PlayerQuery as ChildPlayerQuery;
use Model\Reservation as ChildReservation;
use Model\ReservationQuery as ChildReservationQuery;
use Model\Transactions as ChildTransactions;
use Model\TransactionsQuery as ChildTransactionsQuery;
use Model\Map\GameplayersTableMap;
use Model\Map\GamescoreTableMap;
use Model\Map\PlayerBuyTableMap;
use Model\Map\PlayerTableMap;
use Model\Map\ReservationTableMap;
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
 * Base class that represents a row from the 'player' table.
 *
 *
 *
 * @package    propel.generator.Model.Base
 */
abstract class Player implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Map\\PlayerTableMap';


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
     * The value for the name field.
     *
     * @var        string|null
     */
    protected $name;

    /**
     * The value for the mail field.
     *
     * @var        string|null
     */
    protected $mail;

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
     * @var        ObjectCollection|ChildReservation[] Collection to store aggregation of ChildReservation objects.
     */
    protected $collReservations;
    protected $collReservationsPartial;

    /**
     * @var        ObjectCollection|ChildTransactions[] Collection to store aggregation of ChildTransactions objects.
     */
    protected $collTransactionssRelatedBySourceid;
    protected $collTransactionssRelatedBySourceidPartial;

    /**
     * @var        ObjectCollection|ChildTransactions[] Collection to store aggregation of ChildTransactions objects.
     */
    protected $collTransactionssRelatedByTargetid;
    protected $collTransactionssRelatedByTargetidPartial;

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
     * @var ObjectCollection|ChildReservation[]
     */
    protected $reservationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransactions[]
     */
    protected $transactionssRelatedBySourceidScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransactions[]
     */
    protected $transactionssRelatedByTargetidScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Base\Player object.
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
     * Compares this with another <code>Player</code> instance.  If
     * <code>obj</code> is an instance of <code>Player</code>, delegates to
     * <code>equals(Player)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [name] column value.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [mail] column value.
     *
     * @return string|null
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PlayerTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string|null $v New value
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PlayerTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [mail] column.
     *
     * @param string|null $v New value
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function setMail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mail !== $v) {
            $this->mail = $v;
            $this->modifiedColumns[PlayerTableMap::COL_MAIL] = true;
        }

        return $this;
    } // setMail()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlayerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlayerTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlayerTableMap::translateFieldName('Mail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mail = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PlayerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Player'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PlayerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlayerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collGameplayerss = null;

            $this->collGamescores = null;

            $this->collPlayerBuys = null;

            $this->collReservations = null;

            $this->collTransactionssRelatedBySourceid = null;

            $this->collTransactionssRelatedByTargetid = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Player::setDeleted()
     * @see Player::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlayerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
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
                PlayerTableMap::addInstanceToPool($this);
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

            if ($this->reservationsScheduledForDeletion !== null) {
                if (!$this->reservationsScheduledForDeletion->isEmpty()) {
                    foreach ($this->reservationsScheduledForDeletion as $reservation) {
                        // need to save related object because we set the relation to null
                        $reservation->save($con);
                    }
                    $this->reservationsScheduledForDeletion = null;
                }
            }

            if ($this->collReservations !== null) {
                foreach ($this->collReservations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionssRelatedBySourceidScheduledForDeletion !== null) {
                if (!$this->transactionssRelatedBySourceidScheduledForDeletion->isEmpty()) {
                    foreach ($this->transactionssRelatedBySourceidScheduledForDeletion as $transactionsRelatedBySourceid) {
                        // need to save related object because we set the relation to null
                        $transactionsRelatedBySourceid->save($con);
                    }
                    $this->transactionssRelatedBySourceidScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionssRelatedBySourceid !== null) {
                foreach ($this->collTransactionssRelatedBySourceid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transactionssRelatedByTargetidScheduledForDeletion !== null) {
                if (!$this->transactionssRelatedByTargetidScheduledForDeletion->isEmpty()) {
                    foreach ($this->transactionssRelatedByTargetidScheduledForDeletion as $transactionsRelatedByTargetid) {
                        // need to save related object because we set the relation to null
                        $transactionsRelatedByTargetid->save($con);
                    }
                    $this->transactionssRelatedByTargetidScheduledForDeletion = null;
                }
            }

            if ($this->collTransactionssRelatedByTargetid !== null) {
                foreach ($this->collTransactionssRelatedByTargetid as $referrerFK) {
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

        $this->modifiedColumns[PlayerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlayerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlayerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_MAIL)) {
            $modifiedColumns[':p' . $index++]  = 'mail';
        }

        $sql = sprintf(
            'INSERT INTO player (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'mail':
                        $stmt->bindValue($identifier, $this->mail, PDO::PARAM_STR);
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
        $pos = PlayerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getMail();
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

        if (isset($alreadyDumpedObjects['Player'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Player'][$this->hashCode()] = true;
        $keys = PlayerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getMail(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collReservations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'reservations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'reservations';
                        break;
                    default:
                        $key = 'Reservations';
                }

                $result[$key] = $this->collReservations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionssRelatedBySourceid) {

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

                $result[$key] = $this->collTransactionssRelatedBySourceid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransactionssRelatedByTargetid) {

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

                $result[$key] = $this->collTransactionssRelatedByTargetid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Player
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlayerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Player
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setMail($value);
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
     * @return     $this|\Model\Player
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PlayerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMail($arr[$keys[2]]);
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
     * @return $this|\Model\Player The current object, for fluid interface
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
        $criteria = new Criteria(PlayerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlayerTableMap::COL_ID)) {
            $criteria->add(PlayerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_NAME)) {
            $criteria->add(PlayerTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_MAIL)) {
            $criteria->add(PlayerTableMap::COL_MAIL, $this->mail);
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
        $criteria = ChildPlayerQuery::create();
        $criteria->add(PlayerTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Model\Player (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setMail($this->getMail());

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

            foreach ($this->getReservations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addReservation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionssRelatedBySourceid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionsRelatedBySourceid($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransactionssRelatedByTargetid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransactionsRelatedByTargetid($relObj->copy($deepCopy));
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
     * @return \Model\Player Clone of current object.
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
        if ('Reservation' === $relationName) {
            $this->initReservations();
            return;
        }
        if ('TransactionsRelatedBySourceid' === $relationName) {
            $this->initTransactionssRelatedBySourceid();
            return;
        }
        if ('TransactionsRelatedByTargetid' === $relationName) {
            $this->initTransactionssRelatedByTargetid();
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
     * If this ChildPlayer is new, it will return
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
                    ->filterByPlayer($this)
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
     * @return $this|ChildPlayer The current object (for fluent API support)
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
            $gameplayersRemoved->setPlayer(null);
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
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collGameplayerss);
    }

    /**
     * Method called to associate a ChildGameplayers object to this object
     * through the ChildGameplayers foreign key attribute.
     *
     * @param  ChildGameplayers $l ChildGameplayers
     * @return $this|\Model\Player The current object (for fluent API support)
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
        $gameplayers->setPlayer($this);
    }

    /**
     * @param  ChildGameplayers $gameplayers The ChildGameplayers object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
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
            $gameplayers->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related Gameplayerss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameplayers[] List of ChildGameplayers objects
     */
    public function getGameplayerssJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameplayersQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

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
     * If this ChildPlayer is new, it will return
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
                    ->filterByPlayer($this)
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
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setGamescores(Collection $gamescores, ConnectionInterface $con = null)
    {
        /** @var ChildGamescore[] $gamescoresToDelete */
        $gamescoresToDelete = $this->getGamescores(new Criteria(), $con)->diff($gamescores);


        $this->gamescoresScheduledForDeletion = $gamescoresToDelete;

        foreach ($gamescoresToDelete as $gamescoreRemoved) {
            $gamescoreRemoved->setPlayer(null);
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
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collGamescores);
    }

    /**
     * Method called to associate a ChildGamescore object to this object
     * through the ChildGamescore foreign key attribute.
     *
     * @param  ChildGamescore $l ChildGamescore
     * @return $this|\Model\Player The current object (for fluent API support)
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
        $gamescore->setPlayer($this);
    }

    /**
     * @param  ChildGamescore $gamescore The ChildGamescore object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
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
            $gamescore->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related Gamescores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamescore[] List of ChildGamescore objects
     */
    public function getGamescoresJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamescoreQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getGamescores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related Gamescores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
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
     * If this ChildPlayer is new, it will return
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
                    ->filterByPlayer($this)
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
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setPlayerBuys(Collection $playerBuys, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerBuy[] $playerBuysToDelete */
        $playerBuysToDelete = $this->getPlayerBuys(new Criteria(), $con)->diff($playerBuys);


        $this->playerBuysScheduledForDeletion = $playerBuysToDelete;

        foreach ($playerBuysToDelete as $playerBuyRemoved) {
            $playerBuyRemoved->setPlayer(null);
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
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collPlayerBuys);
    }

    /**
     * Method called to associate a ChildPlayerBuy object to this object
     * through the ChildPlayerBuy foreign key attribute.
     *
     * @param  ChildPlayerBuy $l ChildPlayerBuy
     * @return $this|\Model\Player The current object (for fluent API support)
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
        $playerBuy->setPlayer($this);
    }

    /**
     * @param  ChildPlayerBuy $playerBuy The ChildPlayerBuy object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
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
            $playerBuy->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related PlayerBuys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerBuy[] List of ChildPlayerBuy objects
     */
    public function getPlayerBuysJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerBuyQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getPlayerBuys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related PlayerBuys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
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
     * Clears out the collReservations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addReservations()
     */
    public function clearReservations()
    {
        $this->collReservations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collReservations collection loaded partially.
     */
    public function resetPartialReservations($v = true)
    {
        $this->collReservationsPartial = $v;
    }

    /**
     * Initializes the collReservations collection.
     *
     * By default this just sets the collReservations collection to an empty array (like clearcollReservations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initReservations($overrideExisting = true)
    {
        if (null !== $this->collReservations && !$overrideExisting) {
            return;
        }

        $collectionClassName = ReservationTableMap::getTableMap()->getCollectionClassName();

        $this->collReservations = new $collectionClassName;
        $this->collReservations->setModel('\Model\Reservation');
    }

    /**
     * Gets an array of ChildReservation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildReservation[] List of ChildReservation objects
     * @throws PropelException
     */
    public function getReservations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collReservationsPartial && !$this->isNew();
        if (null === $this->collReservations || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collReservations) {
                    $this->initReservations();
                } else {
                    $collectionClassName = ReservationTableMap::getTableMap()->getCollectionClassName();

                    $collReservations = new $collectionClassName;
                    $collReservations->setModel('\Model\Reservation');

                    return $collReservations;
                }
            } else {
                $collReservations = ChildReservationQuery::create(null, $criteria)
                    ->filterByPlayer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collReservationsPartial && count($collReservations)) {
                        $this->initReservations(false);

                        foreach ($collReservations as $obj) {
                            if (false == $this->collReservations->contains($obj)) {
                                $this->collReservations->append($obj);
                            }
                        }

                        $this->collReservationsPartial = true;
                    }

                    return $collReservations;
                }

                if ($partial && $this->collReservations) {
                    foreach ($this->collReservations as $obj) {
                        if ($obj->isNew()) {
                            $collReservations[] = $obj;
                        }
                    }
                }

                $this->collReservations = $collReservations;
                $this->collReservationsPartial = false;
            }
        }

        return $this->collReservations;
    }

    /**
     * Sets a collection of ChildReservation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $reservations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setReservations(Collection $reservations, ConnectionInterface $con = null)
    {
        /** @var ChildReservation[] $reservationsToDelete */
        $reservationsToDelete = $this->getReservations(new Criteria(), $con)->diff($reservations);


        $this->reservationsScheduledForDeletion = $reservationsToDelete;

        foreach ($reservationsToDelete as $reservationRemoved) {
            $reservationRemoved->setPlayer(null);
        }

        $this->collReservations = null;
        foreach ($reservations as $reservation) {
            $this->addReservation($reservation);
        }

        $this->collReservations = $reservations;
        $this->collReservationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Reservation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Reservation objects.
     * @throws PropelException
     */
    public function countReservations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collReservationsPartial && !$this->isNew();
        if (null === $this->collReservations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collReservations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getReservations());
            }

            $query = ChildReservationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collReservations);
    }

    /**
     * Method called to associate a ChildReservation object to this object
     * through the ChildReservation foreign key attribute.
     *
     * @param  ChildReservation $l ChildReservation
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function addReservation(ChildReservation $l)
    {
        if ($this->collReservations === null) {
            $this->initReservations();
            $this->collReservationsPartial = true;
        }

        if (!$this->collReservations->contains($l)) {
            $this->doAddReservation($l);

            if ($this->reservationsScheduledForDeletion and $this->reservationsScheduledForDeletion->contains($l)) {
                $this->reservationsScheduledForDeletion->remove($this->reservationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildReservation $reservation The ChildReservation object to add.
     */
    protected function doAddReservation(ChildReservation $reservation)
    {
        $this->collReservations[]= $reservation;
        $reservation->setPlayer($this);
    }

    /**
     * @param  ChildReservation $reservation The ChildReservation object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removeReservation(ChildReservation $reservation)
    {
        if ($this->getReservations()->contains($reservation)) {
            $pos = $this->collReservations->search($reservation);
            $this->collReservations->remove($pos);
            if (null === $this->reservationsScheduledForDeletion) {
                $this->reservationsScheduledForDeletion = clone $this->collReservations;
                $this->reservationsScheduledForDeletion->clear();
            }
            $this->reservationsScheduledForDeletion[]= $reservation;
            $reservation->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related Reservations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildReservation[] List of ChildReservation objects
     */
    public function getReservationsJoinGameday(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildReservationQuery::create(null, $criteria);
        $query->joinWith('Gameday', $joinBehavior);

        return $this->getReservations($query, $con);
    }

    /**
     * Clears out the collTransactionssRelatedBySourceid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionssRelatedBySourceid()
     */
    public function clearTransactionssRelatedBySourceid()
    {
        $this->collTransactionssRelatedBySourceid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionssRelatedBySourceid collection loaded partially.
     */
    public function resetPartialTransactionssRelatedBySourceid($v = true)
    {
        $this->collTransactionssRelatedBySourceidPartial = $v;
    }

    /**
     * Initializes the collTransactionssRelatedBySourceid collection.
     *
     * By default this just sets the collTransactionssRelatedBySourceid collection to an empty array (like clearcollTransactionssRelatedBySourceid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionssRelatedBySourceid($overrideExisting = true)
    {
        if (null !== $this->collTransactionssRelatedBySourceid && !$overrideExisting) {
            return;
        }

        $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

        $this->collTransactionssRelatedBySourceid = new $collectionClassName;
        $this->collTransactionssRelatedBySourceid->setModel('\Model\Transactions');
    }

    /**
     * Gets an array of ChildTransactions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     * @throws PropelException
     */
    public function getTransactionssRelatedBySourceid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssRelatedBySourceidPartial && !$this->isNew();
        if (null === $this->collTransactionssRelatedBySourceid || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTransactionssRelatedBySourceid) {
                    $this->initTransactionssRelatedBySourceid();
                } else {
                    $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

                    $collTransactionssRelatedBySourceid = new $collectionClassName;
                    $collTransactionssRelatedBySourceid->setModel('\Model\Transactions');

                    return $collTransactionssRelatedBySourceid;
                }
            } else {
                $collTransactionssRelatedBySourceid = ChildTransactionsQuery::create(null, $criteria)
                    ->filterByPlayerRelatedBySourceid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionssRelatedBySourceidPartial && count($collTransactionssRelatedBySourceid)) {
                        $this->initTransactionssRelatedBySourceid(false);

                        foreach ($collTransactionssRelatedBySourceid as $obj) {
                            if (false == $this->collTransactionssRelatedBySourceid->contains($obj)) {
                                $this->collTransactionssRelatedBySourceid->append($obj);
                            }
                        }

                        $this->collTransactionssRelatedBySourceidPartial = true;
                    }

                    return $collTransactionssRelatedBySourceid;
                }

                if ($partial && $this->collTransactionssRelatedBySourceid) {
                    foreach ($this->collTransactionssRelatedBySourceid as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionssRelatedBySourceid[] = $obj;
                        }
                    }
                }

                $this->collTransactionssRelatedBySourceid = $collTransactionssRelatedBySourceid;
                $this->collTransactionssRelatedBySourceidPartial = false;
            }
        }

        return $this->collTransactionssRelatedBySourceid;
    }

    /**
     * Sets a collection of ChildTransactions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionssRelatedBySourceid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setTransactionssRelatedBySourceid(Collection $transactionssRelatedBySourceid, ConnectionInterface $con = null)
    {
        /** @var ChildTransactions[] $transactionssRelatedBySourceidToDelete */
        $transactionssRelatedBySourceidToDelete = $this->getTransactionssRelatedBySourceid(new Criteria(), $con)->diff($transactionssRelatedBySourceid);


        $this->transactionssRelatedBySourceidScheduledForDeletion = $transactionssRelatedBySourceidToDelete;

        foreach ($transactionssRelatedBySourceidToDelete as $transactionsRelatedBySourceidRemoved) {
            $transactionsRelatedBySourceidRemoved->setPlayerRelatedBySourceid(null);
        }

        $this->collTransactionssRelatedBySourceid = null;
        foreach ($transactionssRelatedBySourceid as $transactionsRelatedBySourceid) {
            $this->addTransactionsRelatedBySourceid($transactionsRelatedBySourceid);
        }

        $this->collTransactionssRelatedBySourceid = $transactionssRelatedBySourceid;
        $this->collTransactionssRelatedBySourceidPartial = false;

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
    public function countTransactionssRelatedBySourceid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssRelatedBySourceidPartial && !$this->isNew();
        if (null === $this->collTransactionssRelatedBySourceid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionssRelatedBySourceid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionssRelatedBySourceid());
            }

            $query = ChildTransactionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayerRelatedBySourceid($this)
                ->count($con);
        }

        return count($this->collTransactionssRelatedBySourceid);
    }

    /**
     * Method called to associate a ChildTransactions object to this object
     * through the ChildTransactions foreign key attribute.
     *
     * @param  ChildTransactions $l ChildTransactions
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function addTransactionsRelatedBySourceid(ChildTransactions $l)
    {
        if ($this->collTransactionssRelatedBySourceid === null) {
            $this->initTransactionssRelatedBySourceid();
            $this->collTransactionssRelatedBySourceidPartial = true;
        }

        if (!$this->collTransactionssRelatedBySourceid->contains($l)) {
            $this->doAddTransactionsRelatedBySourceid($l);

            if ($this->transactionssRelatedBySourceidScheduledForDeletion and $this->transactionssRelatedBySourceidScheduledForDeletion->contains($l)) {
                $this->transactionssRelatedBySourceidScheduledForDeletion->remove($this->transactionssRelatedBySourceidScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTransactions $transactionsRelatedBySourceid The ChildTransactions object to add.
     */
    protected function doAddTransactionsRelatedBySourceid(ChildTransactions $transactionsRelatedBySourceid)
    {
        $this->collTransactionssRelatedBySourceid[]= $transactionsRelatedBySourceid;
        $transactionsRelatedBySourceid->setPlayerRelatedBySourceid($this);
    }

    /**
     * @param  ChildTransactions $transactionsRelatedBySourceid The ChildTransactions object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removeTransactionsRelatedBySourceid(ChildTransactions $transactionsRelatedBySourceid)
    {
        if ($this->getTransactionssRelatedBySourceid()->contains($transactionsRelatedBySourceid)) {
            $pos = $this->collTransactionssRelatedBySourceid->search($transactionsRelatedBySourceid);
            $this->collTransactionssRelatedBySourceid->remove($pos);
            if (null === $this->transactionssRelatedBySourceidScheduledForDeletion) {
                $this->transactionssRelatedBySourceidScheduledForDeletion = clone $this->collTransactionssRelatedBySourceid;
                $this->transactionssRelatedBySourceidScheduledForDeletion->clear();
            }
            $this->transactionssRelatedBySourceidScheduledForDeletion[]= $transactionsRelatedBySourceid;
            $transactionsRelatedBySourceid->setPlayerRelatedBySourceid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related TransactionssRelatedBySourceid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     */
    public function getTransactionssRelatedBySourceidJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionsQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getTransactionssRelatedBySourceid($query, $con);
    }

    /**
     * Clears out the collTransactionssRelatedByTargetid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransactionssRelatedByTargetid()
     */
    public function clearTransactionssRelatedByTargetid()
    {
        $this->collTransactionssRelatedByTargetid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransactionssRelatedByTargetid collection loaded partially.
     */
    public function resetPartialTransactionssRelatedByTargetid($v = true)
    {
        $this->collTransactionssRelatedByTargetidPartial = $v;
    }

    /**
     * Initializes the collTransactionssRelatedByTargetid collection.
     *
     * By default this just sets the collTransactionssRelatedByTargetid collection to an empty array (like clearcollTransactionssRelatedByTargetid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransactionssRelatedByTargetid($overrideExisting = true)
    {
        if (null !== $this->collTransactionssRelatedByTargetid && !$overrideExisting) {
            return;
        }

        $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

        $this->collTransactionssRelatedByTargetid = new $collectionClassName;
        $this->collTransactionssRelatedByTargetid->setModel('\Model\Transactions');
    }

    /**
     * Gets an array of ChildTransactions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     * @throws PropelException
     */
    public function getTransactionssRelatedByTargetid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssRelatedByTargetidPartial && !$this->isNew();
        if (null === $this->collTransactionssRelatedByTargetid || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTransactionssRelatedByTargetid) {
                    $this->initTransactionssRelatedByTargetid();
                } else {
                    $collectionClassName = TransactionsTableMap::getTableMap()->getCollectionClassName();

                    $collTransactionssRelatedByTargetid = new $collectionClassName;
                    $collTransactionssRelatedByTargetid->setModel('\Model\Transactions');

                    return $collTransactionssRelatedByTargetid;
                }
            } else {
                $collTransactionssRelatedByTargetid = ChildTransactionsQuery::create(null, $criteria)
                    ->filterByPlayerRelatedByTargetid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransactionssRelatedByTargetidPartial && count($collTransactionssRelatedByTargetid)) {
                        $this->initTransactionssRelatedByTargetid(false);

                        foreach ($collTransactionssRelatedByTargetid as $obj) {
                            if (false == $this->collTransactionssRelatedByTargetid->contains($obj)) {
                                $this->collTransactionssRelatedByTargetid->append($obj);
                            }
                        }

                        $this->collTransactionssRelatedByTargetidPartial = true;
                    }

                    return $collTransactionssRelatedByTargetid;
                }

                if ($partial && $this->collTransactionssRelatedByTargetid) {
                    foreach ($this->collTransactionssRelatedByTargetid as $obj) {
                        if ($obj->isNew()) {
                            $collTransactionssRelatedByTargetid[] = $obj;
                        }
                    }
                }

                $this->collTransactionssRelatedByTargetid = $collTransactionssRelatedByTargetid;
                $this->collTransactionssRelatedByTargetidPartial = false;
            }
        }

        return $this->collTransactionssRelatedByTargetid;
    }

    /**
     * Sets a collection of ChildTransactions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transactionssRelatedByTargetid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setTransactionssRelatedByTargetid(Collection $transactionssRelatedByTargetid, ConnectionInterface $con = null)
    {
        /** @var ChildTransactions[] $transactionssRelatedByTargetidToDelete */
        $transactionssRelatedByTargetidToDelete = $this->getTransactionssRelatedByTargetid(new Criteria(), $con)->diff($transactionssRelatedByTargetid);


        $this->transactionssRelatedByTargetidScheduledForDeletion = $transactionssRelatedByTargetidToDelete;

        foreach ($transactionssRelatedByTargetidToDelete as $transactionsRelatedByTargetidRemoved) {
            $transactionsRelatedByTargetidRemoved->setPlayerRelatedByTargetid(null);
        }

        $this->collTransactionssRelatedByTargetid = null;
        foreach ($transactionssRelatedByTargetid as $transactionsRelatedByTargetid) {
            $this->addTransactionsRelatedByTargetid($transactionsRelatedByTargetid);
        }

        $this->collTransactionssRelatedByTargetid = $transactionssRelatedByTargetid;
        $this->collTransactionssRelatedByTargetidPartial = false;

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
    public function countTransactionssRelatedByTargetid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransactionssRelatedByTargetidPartial && !$this->isNew();
        if (null === $this->collTransactionssRelatedByTargetid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransactionssRelatedByTargetid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransactionssRelatedByTargetid());
            }

            $query = ChildTransactionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayerRelatedByTargetid($this)
                ->count($con);
        }

        return count($this->collTransactionssRelatedByTargetid);
    }

    /**
     * Method called to associate a ChildTransactions object to this object
     * through the ChildTransactions foreign key attribute.
     *
     * @param  ChildTransactions $l ChildTransactions
     * @return $this|\Model\Player The current object (for fluent API support)
     */
    public function addTransactionsRelatedByTargetid(ChildTransactions $l)
    {
        if ($this->collTransactionssRelatedByTargetid === null) {
            $this->initTransactionssRelatedByTargetid();
            $this->collTransactionssRelatedByTargetidPartial = true;
        }

        if (!$this->collTransactionssRelatedByTargetid->contains($l)) {
            $this->doAddTransactionsRelatedByTargetid($l);

            if ($this->transactionssRelatedByTargetidScheduledForDeletion and $this->transactionssRelatedByTargetidScheduledForDeletion->contains($l)) {
                $this->transactionssRelatedByTargetidScheduledForDeletion->remove($this->transactionssRelatedByTargetidScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTransactions $transactionsRelatedByTargetid The ChildTransactions object to add.
     */
    protected function doAddTransactionsRelatedByTargetid(ChildTransactions $transactionsRelatedByTargetid)
    {
        $this->collTransactionssRelatedByTargetid[]= $transactionsRelatedByTargetid;
        $transactionsRelatedByTargetid->setPlayerRelatedByTargetid($this);
    }

    /**
     * @param  ChildTransactions $transactionsRelatedByTargetid The ChildTransactions object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removeTransactionsRelatedByTargetid(ChildTransactions $transactionsRelatedByTargetid)
    {
        if ($this->getTransactionssRelatedByTargetid()->contains($transactionsRelatedByTargetid)) {
            $pos = $this->collTransactionssRelatedByTargetid->search($transactionsRelatedByTargetid);
            $this->collTransactionssRelatedByTargetid->remove($pos);
            if (null === $this->transactionssRelatedByTargetidScheduledForDeletion) {
                $this->transactionssRelatedByTargetidScheduledForDeletion = clone $this->collTransactionssRelatedByTargetid;
                $this->transactionssRelatedByTargetidScheduledForDeletion->clear();
            }
            $this->transactionssRelatedByTargetidScheduledForDeletion[]= $transactionsRelatedByTargetid;
            $transactionsRelatedByTargetid->setPlayerRelatedByTargetid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related TransactionssRelatedByTargetid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTransactions[] List of ChildTransactions objects
     */
    public function getTransactionssRelatedByTargetidJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTransactionsQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getTransactionssRelatedByTargetid($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->mail = null;
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
            if ($this->collReservations) {
                foreach ($this->collReservations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionssRelatedBySourceid) {
                foreach ($this->collTransactionssRelatedBySourceid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransactionssRelatedByTargetid) {
                foreach ($this->collTransactionssRelatedByTargetid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGameplayerss = null;
        $this->collGamescores = null;
        $this->collPlayerBuys = null;
        $this->collReservations = null;
        $this->collTransactionssRelatedBySourceid = null;
        $this->collTransactionssRelatedByTargetid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlayerTableMap::DEFAULT_STRING_FORMAT);
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
