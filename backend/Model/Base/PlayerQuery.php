<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Player as ChildPlayer;
use Model\PlayerQuery as ChildPlayerQuery;
use Model\Map\PlayerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'player' table.
 *
 *
 *
 * @method     ChildPlayerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPlayerQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPlayerQuery orderByMail($order = Criteria::ASC) Order by the mail column
 *
 * @method     ChildPlayerQuery groupById() Group by the id column
 * @method     ChildPlayerQuery groupByName() Group by the name column
 * @method     ChildPlayerQuery groupByMail() Group by the mail column
 *
 * @method     ChildPlayerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlayerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlayerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlayerQuery leftJoinGameplayers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gameplayers relation
 * @method     ChildPlayerQuery rightJoinGameplayers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gameplayers relation
 * @method     ChildPlayerQuery innerJoinGameplayers($relationAlias = null) Adds a INNER JOIN clause to the query using the Gameplayers relation
 *
 * @method     ChildPlayerQuery joinWithGameplayers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gameplayers relation
 *
 * @method     ChildPlayerQuery leftJoinWithGameplayers() Adds a LEFT JOIN clause and with to the query using the Gameplayers relation
 * @method     ChildPlayerQuery rightJoinWithGameplayers() Adds a RIGHT JOIN clause and with to the query using the Gameplayers relation
 * @method     ChildPlayerQuery innerJoinWithGameplayers() Adds a INNER JOIN clause and with to the query using the Gameplayers relation
 *
 * @method     ChildPlayerQuery leftJoinGamescore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gamescore relation
 * @method     ChildPlayerQuery rightJoinGamescore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gamescore relation
 * @method     ChildPlayerQuery innerJoinGamescore($relationAlias = null) Adds a INNER JOIN clause to the query using the Gamescore relation
 *
 * @method     ChildPlayerQuery joinWithGamescore($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gamescore relation
 *
 * @method     ChildPlayerQuery leftJoinWithGamescore() Adds a LEFT JOIN clause and with to the query using the Gamescore relation
 * @method     ChildPlayerQuery rightJoinWithGamescore() Adds a RIGHT JOIN clause and with to the query using the Gamescore relation
 * @method     ChildPlayerQuery innerJoinWithGamescore() Adds a INNER JOIN clause and with to the query using the Gamescore relation
 *
 * @method     ChildPlayerQuery leftJoinPlayerBuy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerBuy relation
 * @method     ChildPlayerQuery rightJoinPlayerBuy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerBuy relation
 * @method     ChildPlayerQuery innerJoinPlayerBuy($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerBuy relation
 *
 * @method     ChildPlayerQuery joinWithPlayerBuy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlayerBuy relation
 *
 * @method     ChildPlayerQuery leftJoinWithPlayerBuy() Adds a LEFT JOIN clause and with to the query using the PlayerBuy relation
 * @method     ChildPlayerQuery rightJoinWithPlayerBuy() Adds a RIGHT JOIN clause and with to the query using the PlayerBuy relation
 * @method     ChildPlayerQuery innerJoinWithPlayerBuy() Adds a INNER JOIN clause and with to the query using the PlayerBuy relation
 *
 * @method     ChildPlayerQuery leftJoinReservation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Reservation relation
 * @method     ChildPlayerQuery rightJoinReservation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Reservation relation
 * @method     ChildPlayerQuery innerJoinReservation($relationAlias = null) Adds a INNER JOIN clause to the query using the Reservation relation
 *
 * @method     ChildPlayerQuery joinWithReservation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Reservation relation
 *
 * @method     ChildPlayerQuery leftJoinWithReservation() Adds a LEFT JOIN clause and with to the query using the Reservation relation
 * @method     ChildPlayerQuery rightJoinWithReservation() Adds a RIGHT JOIN clause and with to the query using the Reservation relation
 * @method     ChildPlayerQuery innerJoinWithReservation() Adds a INNER JOIN clause and with to the query using the Reservation relation
 *
 * @method     ChildPlayerQuery leftJoinTransactionsRelatedBySourceid($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionsRelatedBySourceid relation
 * @method     ChildPlayerQuery rightJoinTransactionsRelatedBySourceid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionsRelatedBySourceid relation
 * @method     ChildPlayerQuery innerJoinTransactionsRelatedBySourceid($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionsRelatedBySourceid relation
 *
 * @method     ChildPlayerQuery joinWithTransactionsRelatedBySourceid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TransactionsRelatedBySourceid relation
 *
 * @method     ChildPlayerQuery leftJoinWithTransactionsRelatedBySourceid() Adds a LEFT JOIN clause and with to the query using the TransactionsRelatedBySourceid relation
 * @method     ChildPlayerQuery rightJoinWithTransactionsRelatedBySourceid() Adds a RIGHT JOIN clause and with to the query using the TransactionsRelatedBySourceid relation
 * @method     ChildPlayerQuery innerJoinWithTransactionsRelatedBySourceid() Adds a INNER JOIN clause and with to the query using the TransactionsRelatedBySourceid relation
 *
 * @method     ChildPlayerQuery leftJoinTransactionsRelatedByTargetid($relationAlias = null) Adds a LEFT JOIN clause to the query using the TransactionsRelatedByTargetid relation
 * @method     ChildPlayerQuery rightJoinTransactionsRelatedByTargetid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TransactionsRelatedByTargetid relation
 * @method     ChildPlayerQuery innerJoinTransactionsRelatedByTargetid($relationAlias = null) Adds a INNER JOIN clause to the query using the TransactionsRelatedByTargetid relation
 *
 * @method     ChildPlayerQuery joinWithTransactionsRelatedByTargetid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TransactionsRelatedByTargetid relation
 *
 * @method     ChildPlayerQuery leftJoinWithTransactionsRelatedByTargetid() Adds a LEFT JOIN clause and with to the query using the TransactionsRelatedByTargetid relation
 * @method     ChildPlayerQuery rightJoinWithTransactionsRelatedByTargetid() Adds a RIGHT JOIN clause and with to the query using the TransactionsRelatedByTargetid relation
 * @method     ChildPlayerQuery innerJoinWithTransactionsRelatedByTargetid() Adds a INNER JOIN clause and with to the query using the TransactionsRelatedByTargetid relation
 *
 * @method     \Model\GameplayersQuery|\Model\GamescoreQuery|\Model\PlayerBuyQuery|\Model\ReservationQuery|\Model\TransactionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayer|null findOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query
 * @method     ChildPlayer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayer matching the query, or a new ChildPlayer object populated from the query conditions when no match is found
 *
 * @method     ChildPlayer|null findOneById(int $id) Return the first ChildPlayer filtered by the id column
 * @method     ChildPlayer|null findOneByName(string $name) Return the first ChildPlayer filtered by the name column
 * @method     ChildPlayer|null findOneByMail(string $mail) Return the first ChildPlayer filtered by the mail column *

 * @method     ChildPlayer requirePk($key, ConnectionInterface $con = null) Return the ChildPlayer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOne(ConnectionInterface $con = null) Return the first ChildPlayer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer requireOneById(int $id) Return the first ChildPlayer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByName(string $name) Return the first ChildPlayer filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayer requireOneByMail(string $mail) Return the first ChildPlayer filtered by the mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayer objects based on current ModelCriteria
 * @method     ChildPlayer[]|ObjectCollection findById(int $id) Return ChildPlayer objects filtered by the id column
 * @method     ChildPlayer[]|ObjectCollection findByName(string $name) Return ChildPlayer objects filtered by the name column
 * @method     ChildPlayer[]|ObjectCollection findByMail(string $mail) Return ChildPlayer objects filtered by the mail column
 * @method     ChildPlayer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\PlayerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Player', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayerQuery) {
            return $criteria;
        }
        $query = new ChildPlayerQuery();
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
     * @return ChildPlayer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PlayerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlayer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, mail FROM player WHERE id = :p0';
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
            /** @var ChildPlayer $obj */
            $obj = new ChildPlayer();
            $obj->hydrate($row);
            PlayerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlayer|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PlayerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PlayerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterByMail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterByMail('%fooValue%', Criteria::LIKE); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mail The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByMail($mail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerTableMap::COL_MAIL, $mail, $comparison);
    }

    /**
     * Filter the query by a related \Model\Gameplayers object
     *
     * @param \Model\Gameplayers|ObjectCollection $gameplayers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByGameplayers($gameplayers, $comparison = null)
    {
        if ($gameplayers instanceof \Model\Gameplayers) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $gameplayers->getPlayerid(), $comparison);
        } elseif ($gameplayers instanceof ObjectCollection) {
            return $this
                ->useGameplayersQuery()
                ->filterByPrimaryKeys($gameplayers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGameplayers() only accepts arguments of type \Model\Gameplayers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gameplayers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinGameplayers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gameplayers');

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
            $this->addJoinObject($join, 'Gameplayers');
        }

        return $this;
    }

    /**
     * Use the Gameplayers relation Gameplayers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GameplayersQuery A secondary query class using the current class as primary query
     */
    public function useGameplayersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGameplayers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gameplayers', '\Model\GameplayersQuery');
    }

    /**
     * Use the Gameplayers relation Gameplayers object
     *
     * @param callable(\Model\GameplayersQuery):\Model\GameplayersQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGameplayersQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGameplayersQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gameplayers table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GameplayersQuery The inner query object of the EXISTS statement
     */
    public function useGameplayersExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gameplayers', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gameplayers table for a NOT EXISTS query.
     *
     * @see useGameplayersExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GameplayersQuery The inner query object of the NOT EXISTS statement
     */
    public function useGameplayersNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gameplayers', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Gamescore object
     *
     * @param \Model\Gamescore|ObjectCollection $gamescore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByGamescore($gamescore, $comparison = null)
    {
        if ($gamescore instanceof \Model\Gamescore) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $gamescore->getPlayerid(), $comparison);
        } elseif ($gamescore instanceof ObjectCollection) {
            return $this
                ->useGamescoreQuery()
                ->filterByPrimaryKeys($gamescore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamescore() only accepts arguments of type \Model\Gamescore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gamescore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinGamescore($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gamescore');

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
            $this->addJoinObject($join, 'Gamescore');
        }

        return $this;
    }

    /**
     * Use the Gamescore relation Gamescore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GamescoreQuery A secondary query class using the current class as primary query
     */
    public function useGamescoreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamescore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gamescore', '\Model\GamescoreQuery');
    }

    /**
     * Use the Gamescore relation Gamescore object
     *
     * @param callable(\Model\GamescoreQuery):\Model\GamescoreQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamescoreQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGamescoreQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gamescore table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GamescoreQuery The inner query object of the EXISTS statement
     */
    public function useGamescoreExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gamescore', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gamescore table for a NOT EXISTS query.
     *
     * @see useGamescoreExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GamescoreQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamescoreNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gamescore', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\PlayerBuy object
     *
     * @param \Model\PlayerBuy|ObjectCollection $playerBuy the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByPlayerBuy($playerBuy, $comparison = null)
    {
        if ($playerBuy instanceof \Model\PlayerBuy) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $playerBuy->getPlayerid(), $comparison);
        } elseif ($playerBuy instanceof ObjectCollection) {
            return $this
                ->usePlayerBuyQuery()
                ->filterByPrimaryKeys($playerBuy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerBuy() only accepts arguments of type \Model\PlayerBuy or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerBuy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinPlayerBuy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerBuy');

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
            $this->addJoinObject($join, 'PlayerBuy');
        }

        return $this;
    }

    /**
     * Use the PlayerBuy relation PlayerBuy object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PlayerBuyQuery A secondary query class using the current class as primary query
     */
    public function usePlayerBuyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerBuy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerBuy', '\Model\PlayerBuyQuery');
    }

    /**
     * Use the PlayerBuy relation PlayerBuy object
     *
     * @param callable(\Model\PlayerBuyQuery):\Model\PlayerBuyQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayerBuyQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePlayerBuyQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to PlayerBuy table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PlayerBuyQuery The inner query object of the EXISTS statement
     */
    public function usePlayerBuyExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PlayerBuy', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to PlayerBuy table for a NOT EXISTS query.
     *
     * @see usePlayerBuyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PlayerBuyQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayerBuyNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PlayerBuy', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Reservation object
     *
     * @param \Model\Reservation|ObjectCollection $reservation the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByReservation($reservation, $comparison = null)
    {
        if ($reservation instanceof \Model\Reservation) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $reservation->getPlayerid(), $comparison);
        } elseif ($reservation instanceof ObjectCollection) {
            return $this
                ->useReservationQuery()
                ->filterByPrimaryKeys($reservation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByReservation() only accepts arguments of type \Model\Reservation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Reservation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinReservation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Reservation');

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
            $this->addJoinObject($join, 'Reservation');
        }

        return $this;
    }

    /**
     * Use the Reservation relation Reservation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\ReservationQuery A secondary query class using the current class as primary query
     */
    public function useReservationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinReservation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Reservation', '\Model\ReservationQuery');
    }

    /**
     * Use the Reservation relation Reservation object
     *
     * @param callable(\Model\ReservationQuery):\Model\ReservationQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withReservationQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useReservationQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Reservation table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\ReservationQuery The inner query object of the EXISTS statement
     */
    public function useReservationExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Reservation', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Reservation table for a NOT EXISTS query.
     *
     * @see useReservationExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\ReservationQuery The inner query object of the NOT EXISTS statement
     */
    public function useReservationNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Reservation', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Transactions object
     *
     * @param \Model\Transactions|ObjectCollection $transactions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByTransactionsRelatedBySourceid($transactions, $comparison = null)
    {
        if ($transactions instanceof \Model\Transactions) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $transactions->getSourceid(), $comparison);
        } elseif ($transactions instanceof ObjectCollection) {
            return $this
                ->useTransactionsRelatedBySourceidQuery()
                ->filterByPrimaryKeys($transactions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionsRelatedBySourceid() only accepts arguments of type \Model\Transactions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionsRelatedBySourceid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinTransactionsRelatedBySourceid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionsRelatedBySourceid');

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
            $this->addJoinObject($join, 'TransactionsRelatedBySourceid');
        }

        return $this;
    }

    /**
     * Use the TransactionsRelatedBySourceid relation Transactions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\TransactionsQuery A secondary query class using the current class as primary query
     */
    public function useTransactionsRelatedBySourceidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactionsRelatedBySourceid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionsRelatedBySourceid', '\Model\TransactionsQuery');
    }

    /**
     * Use the TransactionsRelatedBySourceid relation Transactions object
     *
     * @param callable(\Model\TransactionsQuery):\Model\TransactionsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTransactionsRelatedBySourceidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useTransactionsRelatedBySourceidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the TransactionsRelatedBySourceid relation to the Transactions table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\TransactionsQuery The inner query object of the EXISTS statement
     */
    public function useTransactionsRelatedBySourceidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('TransactionsRelatedBySourceid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the TransactionsRelatedBySourceid relation to the Transactions table for a NOT EXISTS query.
     *
     * @see useTransactionsRelatedBySourceidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\TransactionsQuery The inner query object of the NOT EXISTS statement
     */
    public function useTransactionsRelatedBySourceidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('TransactionsRelatedBySourceid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Transactions object
     *
     * @param \Model\Transactions|ObjectCollection $transactions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPlayerQuery The current query, for fluid interface
     */
    public function filterByTransactionsRelatedByTargetid($transactions, $comparison = null)
    {
        if ($transactions instanceof \Model\Transactions) {
            return $this
                ->addUsingAlias(PlayerTableMap::COL_ID, $transactions->getTargetid(), $comparison);
        } elseif ($transactions instanceof ObjectCollection) {
            return $this
                ->useTransactionsRelatedByTargetidQuery()
                ->filterByPrimaryKeys($transactions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactionsRelatedByTargetid() only accepts arguments of type \Model\Transactions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TransactionsRelatedByTargetid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function joinTransactionsRelatedByTargetid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TransactionsRelatedByTargetid');

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
            $this->addJoinObject($join, 'TransactionsRelatedByTargetid');
        }

        return $this;
    }

    /**
     * Use the TransactionsRelatedByTargetid relation Transactions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\TransactionsQuery A secondary query class using the current class as primary query
     */
    public function useTransactionsRelatedByTargetidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactionsRelatedByTargetid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TransactionsRelatedByTargetid', '\Model\TransactionsQuery');
    }

    /**
     * Use the TransactionsRelatedByTargetid relation Transactions object
     *
     * @param callable(\Model\TransactionsQuery):\Model\TransactionsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTransactionsRelatedByTargetidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useTransactionsRelatedByTargetidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the TransactionsRelatedByTargetid relation to the Transactions table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\TransactionsQuery The inner query object of the EXISTS statement
     */
    public function useTransactionsRelatedByTargetidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('TransactionsRelatedByTargetid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the TransactionsRelatedByTargetid relation to the Transactions table for a NOT EXISTS query.
     *
     * @see useTransactionsRelatedByTargetidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\TransactionsQuery The inner query object of the NOT EXISTS statement
     */
    public function useTransactionsRelatedByTargetidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('TransactionsRelatedByTargetid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildPlayer $player Object to remove from the list of results
     *
     * @return $this|ChildPlayerQuery The current query, for fluid interface
     */
    public function prune($player = null)
    {
        if ($player) {
            $this->addUsingAlias(PlayerTableMap::COL_ID, $player->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the player table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayerTableMap::clearInstancePool();
            PlayerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayerQuery
