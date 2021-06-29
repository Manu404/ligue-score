<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Reservation as ChildReservation;
use Model\ReservationQuery as ChildReservationQuery;
use Model\Map\ReservationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'reservation' table.
 *
 *
 *
 * @method     ChildReservationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildReservationQuery orderByPlayerid($order = Criteria::ASC) Order by the playerid column
 * @method     ChildReservationQuery orderByDayid($order = Criteria::ASC) Order by the dayid column
 *
 * @method     ChildReservationQuery groupById() Group by the id column
 * @method     ChildReservationQuery groupByPlayerid() Group by the playerid column
 * @method     ChildReservationQuery groupByDayid() Group by the dayid column
 *
 * @method     ChildReservationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildReservationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildReservationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildReservationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildReservationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildReservationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildReservationQuery leftJoinGameday($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gameday relation
 * @method     ChildReservationQuery rightJoinGameday($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gameday relation
 * @method     ChildReservationQuery innerJoinGameday($relationAlias = null) Adds a INNER JOIN clause to the query using the Gameday relation
 *
 * @method     ChildReservationQuery joinWithGameday($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gameday relation
 *
 * @method     ChildReservationQuery leftJoinWithGameday() Adds a LEFT JOIN clause and with to the query using the Gameday relation
 * @method     ChildReservationQuery rightJoinWithGameday() Adds a RIGHT JOIN clause and with to the query using the Gameday relation
 * @method     ChildReservationQuery innerJoinWithGameday() Adds a INNER JOIN clause and with to the query using the Gameday relation
 *
 * @method     ChildReservationQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildReservationQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildReservationQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     ChildReservationQuery joinWithPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Player relation
 *
 * @method     ChildReservationQuery leftJoinWithPlayer() Adds a LEFT JOIN clause and with to the query using the Player relation
 * @method     ChildReservationQuery rightJoinWithPlayer() Adds a RIGHT JOIN clause and with to the query using the Player relation
 * @method     ChildReservationQuery innerJoinWithPlayer() Adds a INNER JOIN clause and with to the query using the Player relation
 *
 * @method     \Model\GamedayQuery|\Model\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildReservation|null findOne(ConnectionInterface $con = null) Return the first ChildReservation matching the query
 * @method     ChildReservation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildReservation matching the query, or a new ChildReservation object populated from the query conditions when no match is found
 *
 * @method     ChildReservation|null findOneById(int $id) Return the first ChildReservation filtered by the id column
 * @method     ChildReservation|null findOneByPlayerid(int $playerid) Return the first ChildReservation filtered by the playerid column
 * @method     ChildReservation|null findOneByDayid(int $dayid) Return the first ChildReservation filtered by the dayid column *

 * @method     ChildReservation requirePk($key, ConnectionInterface $con = null) Return the ChildReservation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReservation requireOne(ConnectionInterface $con = null) Return the first ChildReservation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildReservation requireOneById(int $id) Return the first ChildReservation filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReservation requireOneByPlayerid(int $playerid) Return the first ChildReservation filtered by the playerid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReservation requireOneByDayid(int $dayid) Return the first ChildReservation filtered by the dayid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildReservation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildReservation objects based on current ModelCriteria
 * @method     ChildReservation[]|ObjectCollection findById(int $id) Return ChildReservation objects filtered by the id column
 * @method     ChildReservation[]|ObjectCollection findByPlayerid(int $playerid) Return ChildReservation objects filtered by the playerid column
 * @method     ChildReservation[]|ObjectCollection findByDayid(int $dayid) Return ChildReservation objects filtered by the dayid column
 * @method     ChildReservation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ReservationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\ReservationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Reservation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildReservationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildReservationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildReservationQuery) {
            return $criteria;
        }
        $query = new ChildReservationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildReservation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ReservationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ReservationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildReservation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, playerid, dayid FROM reservation WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildReservation $obj */
            $obj = new ChildReservation();
            $obj->hydrate($row);
            ReservationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildReservation|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ReservationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ReservationTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ReservationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ReservationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReservationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the playerid column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayerid(1234); // WHERE playerid = 1234
     * $query->filterByPlayerid(array(12, 34)); // WHERE playerid IN (12, 34)
     * $query->filterByPlayerid(array('min' => 12)); // WHERE playerid > 12
     * </code>
     *
     * @see       filterByPlayer()
     *
     * @param     mixed $playerid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function filterByPlayerid($playerid = null, $comparison = null)
    {
        if (is_array($playerid)) {
            $useMinMax = false;
            if (isset($playerid['min'])) {
                $this->addUsingAlias(ReservationTableMap::COL_PLAYERID, $playerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerid['max'])) {
                $this->addUsingAlias(ReservationTableMap::COL_PLAYERID, $playerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReservationTableMap::COL_PLAYERID, $playerid, $comparison);
    }

    /**
     * Filter the query on the dayid column
     *
     * Example usage:
     * <code>
     * $query->filterByDayid(1234); // WHERE dayid = 1234
     * $query->filterByDayid(array(12, 34)); // WHERE dayid IN (12, 34)
     * $query->filterByDayid(array('min' => 12)); // WHERE dayid > 12
     * </code>
     *
     * @see       filterByGameday()
     *
     * @param     mixed $dayid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function filterByDayid($dayid = null, $comparison = null)
    {
        if (is_array($dayid)) {
            $useMinMax = false;
            if (isset($dayid['min'])) {
                $this->addUsingAlias(ReservationTableMap::COL_DAYID, $dayid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dayid['max'])) {
                $this->addUsingAlias(ReservationTableMap::COL_DAYID, $dayid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReservationTableMap::COL_DAYID, $dayid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Gameday object
     *
     * @param \Model\Gameday|ObjectCollection $gameday The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildReservationQuery The current query, for fluid interface
     */
    public function filterByGameday($gameday, $comparison = null)
    {
        if ($gameday instanceof \Model\Gameday) {
            return $this
                ->addUsingAlias(ReservationTableMap::COL_DAYID, $gameday->getId(), $comparison);
        } elseif ($gameday instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReservationTableMap::COL_DAYID, $gameday->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGameday() only accepts arguments of type \Model\Gameday or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gameday relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function joinGameday($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gameday');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Gameday');
        }

        return $this;
    }

    /**
     * Use the Gameday relation Gameday object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GamedayQuery A secondary query class using the current class as primary query
     */
    public function useGamedayQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGameday($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gameday', '\Model\GamedayQuery');
    }

    /**
     * Use the Gameday relation Gameday object
     *
     * @param callable(\Model\GamedayQuery):\Model\GamedayQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamedayQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGamedayQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gameday table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GamedayQuery The inner query object of the EXISTS statement
     */
    public function useGamedayExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gameday', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gameday table for a NOT EXISTS query.
     *
     * @see useGamedayExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GamedayQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamedayNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gameday', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Player object
     *
     * @param \Model\Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildReservationQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Model\Player) {
            return $this
                ->addUsingAlias(ReservationTableMap::COL_PLAYERID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReservationTableMap::COL_PLAYERID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayer() only accepts arguments of type \Model\Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Player relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function joinPlayer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Player');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Player');
        }

        return $this;
    }

    /**
     * Use the Player relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PlayerQuery A secondary query class using the current class as primary query
     */
    public function usePlayerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Player', '\Model\PlayerQuery');
    }

    /**
     * Use the Player relation Player object
     *
     * @param callable(\Model\PlayerQuery):\Model\PlayerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePlayerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Player table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PlayerQuery The inner query object of the EXISTS statement
     */
    public function usePlayerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Player', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Player table for a NOT EXISTS query.
     *
     * @see usePlayerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PlayerQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Player', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildReservation $reservation Object to remove from the list of results
     *
     * @return $this|ChildReservationQuery The current query, for fluid interface
     */
    public function prune($reservation = null)
    {
        if ($reservation) {
            $this->addUsingAlias(ReservationTableMap::COL_ID, $reservation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the reservation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ReservationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ReservationTableMap::clearInstancePool();
            ReservationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ReservationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ReservationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ReservationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ReservationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ReservationQuery
