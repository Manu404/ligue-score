<?php

namespace Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Model\Game as ChildGame;
use Model\GameQuery as ChildGameQuery;
use Model\Gameday as ChildGameday;
use Model\GamedayQuery as ChildGamedayQuery;
use Model\Gamedayruleset as ChildGamedayruleset;
use Model\GamedayrulesetQuery as ChildGamedayrulesetQuery;
use Model\Reservation as ChildReservation;
use Model\ReservationQuery as ChildReservationQuery;
use Model\Map\GameTableMap;
use Model\Map\GamedayTableMap;
use Model\Map\GamedayrulesetTableMap;
use Model\Map\ReservationTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'gameday' table.
 *
 *
 *
 * @package    propel.generator.Model.Base
 */
abstract class Gameday implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Map\\GamedayTableMap';


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
     * The value for the date field.
     *
     * @var        DateTime|null
     */
    protected $date;

    /**
     * @var        ObjectCollection|ChildGame[] Collection to store aggregation of ChildGame objects.
     */
    protected $collGames;
    protected $collGamesPartial;

    /**
     * @var        ObjectCollection|ChildGamedayruleset[] Collection to store aggregation of ChildGamedayruleset objects.
     */
    protected $collGamedayrulesets;
    protected $collGamedayrulesetsPartial;

    /**
     * @var        ObjectCollection|ChildReservation[] Collection to store aggregation of ChildReservation objects.
     */
    protected $collReservations;
    protected $collReservationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGame[]
     */
    protected $gamesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGamedayruleset[]
     */
    protected $gamedayrulesetsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildReservation[]
     */
    protected $reservationsScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Base\Gameday object.
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
     * Compares this with another <code>Gameday</code> instance.  If
     * <code>obj</code> is an instance of <code>Gameday</code>, delegates to
     * <code>equals(Gameday)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getDate($format = null)
    {
        if ($format === null) {
            return $this->date;
        } else {
            return $this->date instanceof \DateTimeInterface ? $this->date->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this|\Model\Gameday The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GamedayTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Model\Gameday The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            if ($this->date === null || $dt === null || $dt->format("Y-m-d") !== $this->date->format("Y-m-d")) {
                $this->date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[GamedayTableMap::COL_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setDate()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GamedayTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GamedayTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = GamedayTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Gameday'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(GamedayTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGamedayQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collGames = null;

            $this->collGamedayrulesets = null;

            $this->collReservations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Gameday::setDeleted()
     * @see Gameday::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGamedayQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayTableMap::DATABASE_NAME);
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
                GamedayTableMap::addInstanceToPool($this);
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

            if ($this->gamesScheduledForDeletion !== null) {
                if (!$this->gamesScheduledForDeletion->isEmpty()) {
                    foreach ($this->gamesScheduledForDeletion as $game) {
                        // need to save related object because we set the relation to null
                        $game->save($con);
                    }
                    $this->gamesScheduledForDeletion = null;
                }
            }

            if ($this->collGames !== null) {
                foreach ($this->collGames as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gamedayrulesetsScheduledForDeletion !== null) {
                if (!$this->gamedayrulesetsScheduledForDeletion->isEmpty()) {
                    foreach ($this->gamedayrulesetsScheduledForDeletion as $gamedayruleset) {
                        // need to save related object because we set the relation to null
                        $gamedayruleset->save($con);
                    }
                    $this->gamedayrulesetsScheduledForDeletion = null;
                }
            }

            if ($this->collGamedayrulesets !== null) {
                foreach ($this->collGamedayrulesets as $referrerFK) {
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

        $this->modifiedColumns[GamedayTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GamedayTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GamedayTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GamedayTableMap::COL_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'date';
        }

        $sql = sprintf(
            'INSERT INTO gameday (%s) VALUES (%s)',
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
                    case 'date':
                        $stmt->bindValue($identifier, $this->date ? $this->date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = GamedayTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDate();
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

        if (isset($alreadyDumpedObjects['Gameday'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Gameday'][$this->hashCode()] = true;
        $keys = GamedayTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDate(),
        );
        if ($result[$keys[1]] instanceof \DateTimeInterface) {
            $result[$keys[1]] = $result[$keys[1]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collGames) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'games';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'games';
                        break;
                    default:
                        $key = 'Games';
                }

                $result[$key] = $this->collGames->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGamedayrulesets) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gamedayrulesets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'gamedayrulesets';
                        break;
                    default:
                        $key = 'Gamedayrulesets';
                }

                $result[$key] = $this->collGamedayrulesets->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Gameday
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GamedayTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Gameday
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDate($value);
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
     * @return     $this|\Model\Gameday
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GamedayTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDate($arr[$keys[1]]);
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
     * @return $this|\Model\Gameday The current object, for fluid interface
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
        $criteria = new Criteria(GamedayTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GamedayTableMap::COL_ID)) {
            $criteria->add(GamedayTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GamedayTableMap::COL_DATE)) {
            $criteria->add(GamedayTableMap::COL_DATE, $this->date);
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
        $criteria = ChildGamedayQuery::create();
        $criteria->add(GamedayTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Model\Gameday (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDate($this->getDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGames() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGame($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGamedayrulesets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGamedayruleset($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getReservations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addReservation($relObj->copy($deepCopy));
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
     * @return \Model\Gameday Clone of current object.
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
        if ('Game' === $relationName) {
            $this->initGames();
            return;
        }
        if ('Gamedayruleset' === $relationName) {
            $this->initGamedayrulesets();
            return;
        }
        if ('Reservation' === $relationName) {
            $this->initReservations();
            return;
        }
    }

    /**
     * Clears out the collGames collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGames()
     */
    public function clearGames()
    {
        $this->collGames = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGames collection loaded partially.
     */
    public function resetPartialGames($v = true)
    {
        $this->collGamesPartial = $v;
    }

    /**
     * Initializes the collGames collection.
     *
     * By default this just sets the collGames collection to an empty array (like clearcollGames());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGames($overrideExisting = true)
    {
        if (null !== $this->collGames && !$overrideExisting) {
            return;
        }

        $collectionClassName = GameTableMap::getTableMap()->getCollectionClassName();

        $this->collGames = new $collectionClassName;
        $this->collGames->setModel('\Model\Game');
    }

    /**
     * Gets an array of ChildGame objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGameday is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     * @throws PropelException
     */
    public function getGames(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesPartial && !$this->isNew();
        if (null === $this->collGames || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGames) {
                    $this->initGames();
                } else {
                    $collectionClassName = GameTableMap::getTableMap()->getCollectionClassName();

                    $collGames = new $collectionClassName;
                    $collGames->setModel('\Model\Game');

                    return $collGames;
                }
            } else {
                $collGames = ChildGameQuery::create(null, $criteria)
                    ->filterByGameday($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamesPartial && count($collGames)) {
                        $this->initGames(false);

                        foreach ($collGames as $obj) {
                            if (false == $this->collGames->contains($obj)) {
                                $this->collGames->append($obj);
                            }
                        }

                        $this->collGamesPartial = true;
                    }

                    return $collGames;
                }

                if ($partial && $this->collGames) {
                    foreach ($this->collGames as $obj) {
                        if ($obj->isNew()) {
                            $collGames[] = $obj;
                        }
                    }
                }

                $this->collGames = $collGames;
                $this->collGamesPartial = false;
            }
        }

        return $this->collGames;
    }

    /**
     * Sets a collection of ChildGame objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $games A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGameday The current object (for fluent API support)
     */
    public function setGames(Collection $games, ConnectionInterface $con = null)
    {
        /** @var ChildGame[] $gamesToDelete */
        $gamesToDelete = $this->getGames(new Criteria(), $con)->diff($games);


        $this->gamesScheduledForDeletion = $gamesToDelete;

        foreach ($gamesToDelete as $gameRemoved) {
            $gameRemoved->setGameday(null);
        }

        $this->collGames = null;
        foreach ($games as $game) {
            $this->addGame($game);
        }

        $this->collGames = $games;
        $this->collGamesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Game objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Game objects.
     * @throws PropelException
     */
    public function countGames(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesPartial && !$this->isNew();
        if (null === $this->collGames || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGames) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGames());
            }

            $query = ChildGameQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGameday($this)
                ->count($con);
        }

        return count($this->collGames);
    }

    /**
     * Method called to associate a ChildGame object to this object
     * through the ChildGame foreign key attribute.
     *
     * @param  ChildGame $l ChildGame
     * @return $this|\Model\Gameday The current object (for fluent API support)
     */
    public function addGame(ChildGame $l)
    {
        if ($this->collGames === null) {
            $this->initGames();
            $this->collGamesPartial = true;
        }

        if (!$this->collGames->contains($l)) {
            $this->doAddGame($l);

            if ($this->gamesScheduledForDeletion and $this->gamesScheduledForDeletion->contains($l)) {
                $this->gamesScheduledForDeletion->remove($this->gamesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGame $game The ChildGame object to add.
     */
    protected function doAddGame(ChildGame $game)
    {
        $this->collGames[]= $game;
        $game->setGameday($this);
    }

    /**
     * @param  ChildGame $game The ChildGame object to remove.
     * @return $this|ChildGameday The current object (for fluent API support)
     */
    public function removeGame(ChildGame $game)
    {
        if ($this->getGames()->contains($game)) {
            $pos = $this->collGames->search($game);
            $this->collGames->remove($pos);
            if (null === $this->gamesScheduledForDeletion) {
                $this->gamesScheduledForDeletion = clone $this->collGames;
                $this->gamesScheduledForDeletion->clear();
            }
            $this->gamesScheduledForDeletion[]= $game;
            $game->setGameday(null);
        }

        return $this;
    }

    /**
     * Clears out the collGamedayrulesets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamedayrulesets()
     */
    public function clearGamedayrulesets()
    {
        $this->collGamedayrulesets = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGamedayrulesets collection loaded partially.
     */
    public function resetPartialGamedayrulesets($v = true)
    {
        $this->collGamedayrulesetsPartial = $v;
    }

    /**
     * Initializes the collGamedayrulesets collection.
     *
     * By default this just sets the collGamedayrulesets collection to an empty array (like clearcollGamedayrulesets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamedayrulesets($overrideExisting = true)
    {
        if (null !== $this->collGamedayrulesets && !$overrideExisting) {
            return;
        }

        $collectionClassName = GamedayrulesetTableMap::getTableMap()->getCollectionClassName();

        $this->collGamedayrulesets = new $collectionClassName;
        $this->collGamedayrulesets->setModel('\Model\Gamedayruleset');
    }

    /**
     * Gets an array of ChildGamedayruleset objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGameday is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGamedayruleset[] List of ChildGamedayruleset objects
     * @throws PropelException
     */
    public function getGamedayrulesets(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamedayrulesetsPartial && !$this->isNew();
        if (null === $this->collGamedayrulesets || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGamedayrulesets) {
                    $this->initGamedayrulesets();
                } else {
                    $collectionClassName = GamedayrulesetTableMap::getTableMap()->getCollectionClassName();

                    $collGamedayrulesets = new $collectionClassName;
                    $collGamedayrulesets->setModel('\Model\Gamedayruleset');

                    return $collGamedayrulesets;
                }
            } else {
                $collGamedayrulesets = ChildGamedayrulesetQuery::create(null, $criteria)
                    ->filterByGameday($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamedayrulesetsPartial && count($collGamedayrulesets)) {
                        $this->initGamedayrulesets(false);

                        foreach ($collGamedayrulesets as $obj) {
                            if (false == $this->collGamedayrulesets->contains($obj)) {
                                $this->collGamedayrulesets->append($obj);
                            }
                        }

                        $this->collGamedayrulesetsPartial = true;
                    }

                    return $collGamedayrulesets;
                }

                if ($partial && $this->collGamedayrulesets) {
                    foreach ($this->collGamedayrulesets as $obj) {
                        if ($obj->isNew()) {
                            $collGamedayrulesets[] = $obj;
                        }
                    }
                }

                $this->collGamedayrulesets = $collGamedayrulesets;
                $this->collGamedayrulesetsPartial = false;
            }
        }

        return $this->collGamedayrulesets;
    }

    /**
     * Sets a collection of ChildGamedayruleset objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gamedayrulesets A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGameday The current object (for fluent API support)
     */
    public function setGamedayrulesets(Collection $gamedayrulesets, ConnectionInterface $con = null)
    {
        /** @var ChildGamedayruleset[] $gamedayrulesetsToDelete */
        $gamedayrulesetsToDelete = $this->getGamedayrulesets(new Criteria(), $con)->diff($gamedayrulesets);


        $this->gamedayrulesetsScheduledForDeletion = $gamedayrulesetsToDelete;

        foreach ($gamedayrulesetsToDelete as $gamedayrulesetRemoved) {
            $gamedayrulesetRemoved->setGameday(null);
        }

        $this->collGamedayrulesets = null;
        foreach ($gamedayrulesets as $gamedayruleset) {
            $this->addGamedayruleset($gamedayruleset);
        }

        $this->collGamedayrulesets = $gamedayrulesets;
        $this->collGamedayrulesetsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Gamedayruleset objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Gamedayruleset objects.
     * @throws PropelException
     */
    public function countGamedayrulesets(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamedayrulesetsPartial && !$this->isNew();
        if (null === $this->collGamedayrulesets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamedayrulesets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGamedayrulesets());
            }

            $query = ChildGamedayrulesetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGameday($this)
                ->count($con);
        }

        return count($this->collGamedayrulesets);
    }

    /**
     * Method called to associate a ChildGamedayruleset object to this object
     * through the ChildGamedayruleset foreign key attribute.
     *
     * @param  ChildGamedayruleset $l ChildGamedayruleset
     * @return $this|\Model\Gameday The current object (for fluent API support)
     */
    public function addGamedayruleset(ChildGamedayruleset $l)
    {
        if ($this->collGamedayrulesets === null) {
            $this->initGamedayrulesets();
            $this->collGamedayrulesetsPartial = true;
        }

        if (!$this->collGamedayrulesets->contains($l)) {
            $this->doAddGamedayruleset($l);

            if ($this->gamedayrulesetsScheduledForDeletion and $this->gamedayrulesetsScheduledForDeletion->contains($l)) {
                $this->gamedayrulesetsScheduledForDeletion->remove($this->gamedayrulesetsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGamedayruleset $gamedayruleset The ChildGamedayruleset object to add.
     */
    protected function doAddGamedayruleset(ChildGamedayruleset $gamedayruleset)
    {
        $this->collGamedayrulesets[]= $gamedayruleset;
        $gamedayruleset->setGameday($this);
    }

    /**
     * @param  ChildGamedayruleset $gamedayruleset The ChildGamedayruleset object to remove.
     * @return $this|ChildGameday The current object (for fluent API support)
     */
    public function removeGamedayruleset(ChildGamedayruleset $gamedayruleset)
    {
        if ($this->getGamedayrulesets()->contains($gamedayruleset)) {
            $pos = $this->collGamedayrulesets->search($gamedayruleset);
            $this->collGamedayrulesets->remove($pos);
            if (null === $this->gamedayrulesetsScheduledForDeletion) {
                $this->gamedayrulesetsScheduledForDeletion = clone $this->collGamedayrulesets;
                $this->gamedayrulesetsScheduledForDeletion->clear();
            }
            $this->gamedayrulesetsScheduledForDeletion[]= $gamedayruleset;
            $gamedayruleset->setGameday(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gameday is new, it will return
     * an empty collection; or if this Gameday has previously
     * been saved, it will retrieve related Gamedayrulesets from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gameday.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamedayruleset[] List of ChildGamedayruleset objects
     */
    public function getGamedayrulesetsJoinGametype(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamedayrulesetQuery::create(null, $criteria);
        $query->joinWith('Gametype', $joinBehavior);

        return $this->getGamedayrulesets($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gameday is new, it will return
     * an empty collection; or if this Gameday has previously
     * been saved, it will retrieve related Gamedayrulesets from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gameday.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGamedayruleset[] List of ChildGamedayruleset objects
     */
    public function getGamedayrulesetsJoinRuleset(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGamedayrulesetQuery::create(null, $criteria);
        $query->joinWith('Ruleset', $joinBehavior);

        return $this->getGamedayrulesets($query, $con);
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
     * If this ChildGameday is new, it will return
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
                    ->filterByGameday($this)
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
     * @return $this|ChildGameday The current object (for fluent API support)
     */
    public function setReservations(Collection $reservations, ConnectionInterface $con = null)
    {
        /** @var ChildReservation[] $reservationsToDelete */
        $reservationsToDelete = $this->getReservations(new Criteria(), $con)->diff($reservations);


        $this->reservationsScheduledForDeletion = $reservationsToDelete;

        foreach ($reservationsToDelete as $reservationRemoved) {
            $reservationRemoved->setGameday(null);
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
                ->filterByGameday($this)
                ->count($con);
        }

        return count($this->collReservations);
    }

    /**
     * Method called to associate a ChildReservation object to this object
     * through the ChildReservation foreign key attribute.
     *
     * @param  ChildReservation $l ChildReservation
     * @return $this|\Model\Gameday The current object (for fluent API support)
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
        $reservation->setGameday($this);
    }

    /**
     * @param  ChildReservation $reservation The ChildReservation object to remove.
     * @return $this|ChildGameday The current object (for fluent API support)
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
            $reservation->setGameday(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Gameday is new, it will return
     * an empty collection; or if this Gameday has previously
     * been saved, it will retrieve related Reservations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Gameday.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildReservation[] List of ChildReservation objects
     */
    public function getReservationsJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildReservationQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getReservations($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->date = null;
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
            if ($this->collGames) {
                foreach ($this->collGames as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGamedayrulesets) {
                foreach ($this->collGamedayrulesets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collReservations) {
                foreach ($this->collReservations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGames = null;
        $this->collGamedayrulesets = null;
        $this->collReservations = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GamedayTableMap::DEFAULT_STRING_FORMAT);
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
