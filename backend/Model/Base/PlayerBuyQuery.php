<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\PlayerBuy as ChildPlayerBuy;
use Model\PlayerBuyQuery as ChildPlayerBuyQuery;
use Model\Map\PlayerBuyTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'player_buy' table.
 *
 *
 *
 * @method     ChildPlayerBuyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPlayerBuyQuery orderByPlayerid($order = Criteria::ASC) Order by the playerid column
 * @method     ChildPlayerBuyQuery orderByItemid($order = Criteria::ASC) Order by the itemid column
 * @method     ChildPlayerBuyQuery orderByGameid($order = Criteria::ASC) Order by the gameid column
 *
 * @method     ChildPlayerBuyQuery groupById() Group by the id column
 * @method     ChildPlayerBuyQuery groupByPlayerid() Group by the playerid column
 * @method     ChildPlayerBuyQuery groupByItemid() Group by the itemid column
 * @method     ChildPlayerBuyQuery groupByGameid() Group by the gameid column
 *
 * @method     ChildPlayerBuyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlayerBuyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlayerBuyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlayerBuyQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlayerBuyQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlayerBuyQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlayerBuyQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildPlayerBuyQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildPlayerBuyQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildPlayerBuyQuery joinWithGame($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Game relation
 *
 * @method     ChildPlayerBuyQuery leftJoinWithGame() Adds a LEFT JOIN clause and with to the query using the Game relation
 * @method     ChildPlayerBuyQuery rightJoinWithGame() Adds a RIGHT JOIN clause and with to the query using the Game relation
 * @method     ChildPlayerBuyQuery innerJoinWithGame() Adds a INNER JOIN clause and with to the query using the Game relation
 *
 * @method     ChildPlayerBuyQuery leftJoinShopitems($relationAlias = null) Adds a LEFT JOIN clause to the query using the Shopitems relation
 * @method     ChildPlayerBuyQuery rightJoinShopitems($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Shopitems relation
 * @method     ChildPlayerBuyQuery innerJoinShopitems($relationAlias = null) Adds a INNER JOIN clause to the query using the Shopitems relation
 *
 * @method     ChildPlayerBuyQuery joinWithShopitems($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Shopitems relation
 *
 * @method     ChildPlayerBuyQuery leftJoinWithShopitems() Adds a LEFT JOIN clause and with to the query using the Shopitems relation
 * @method     ChildPlayerBuyQuery rightJoinWithShopitems() Adds a RIGHT JOIN clause and with to the query using the Shopitems relation
 * @method     ChildPlayerBuyQuery innerJoinWithShopitems() Adds a INNER JOIN clause and with to the query using the Shopitems relation
 *
 * @method     ChildPlayerBuyQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildPlayerBuyQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildPlayerBuyQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     ChildPlayerBuyQuery joinWithPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Player relation
 *
 * @method     ChildPlayerBuyQuery leftJoinWithPlayer() Adds a LEFT JOIN clause and with to the query using the Player relation
 * @method     ChildPlayerBuyQuery rightJoinWithPlayer() Adds a RIGHT JOIN clause and with to the query using the Player relation
 * @method     ChildPlayerBuyQuery innerJoinWithPlayer() Adds a INNER JOIN clause and with to the query using the Player relation
 *
 * @method     \Model\GameQuery|\Model\ShopitemsQuery|\Model\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlayerBuy|null findOne(ConnectionInterface $con = null) Return the first ChildPlayerBuy matching the query
 * @method     ChildPlayerBuy findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlayerBuy matching the query, or a new ChildPlayerBuy object populated from the query conditions when no match is found
 *
 * @method     ChildPlayerBuy|null findOneById(int $id) Return the first ChildPlayerBuy filtered by the id column
 * @method     ChildPlayerBuy|null findOneByPlayerid(int $playerid) Return the first ChildPlayerBuy filtered by the playerid column
 * @method     ChildPlayerBuy|null findOneByItemid(int $itemid) Return the first ChildPlayerBuy filtered by the itemid column
 * @method     ChildPlayerBuy|null findOneByGameid(int $gameid) Return the first ChildPlayerBuy filtered by the gameid column *

 * @method     ChildPlayerBuy requirePk($key, ConnectionInterface $con = null) Return the ChildPlayerBuy by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerBuy requireOne(ConnectionInterface $con = null) Return the first ChildPlayerBuy matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayerBuy requireOneById(int $id) Return the first ChildPlayerBuy filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerBuy requireOneByPlayerid(int $playerid) Return the first ChildPlayerBuy filtered by the playerid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerBuy requireOneByItemid(int $itemid) Return the first ChildPlayerBuy filtered by the itemid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlayerBuy requireOneByGameid(int $gameid) Return the first ChildPlayerBuy filtered by the gameid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlayerBuy[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlayerBuy objects based on current ModelCriteria
 * @method     ChildPlayerBuy[]|ObjectCollection findById(int $id) Return ChildPlayerBuy objects filtered by the id column
 * @method     ChildPlayerBuy[]|ObjectCollection findByPlayerid(int $playerid) Return ChildPlayerBuy objects filtered by the playerid column
 * @method     ChildPlayerBuy[]|ObjectCollection findByItemid(int $itemid) Return ChildPlayerBuy objects filtered by the itemid column
 * @method     ChildPlayerBuy[]|ObjectCollection findByGameid(int $gameid) Return ChildPlayerBuy objects filtered by the gameid column
 * @method     ChildPlayerBuy[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlayerBuyQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\PlayerBuyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\PlayerBuy', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlayerBuyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlayerBuyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlayerBuyQuery) {
            return $criteria;
        }
        $query = new ChildPlayerBuyQuery();
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
     * @return ChildPlayerBuy|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlayerBuyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PlayerBuyTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlayerBuy A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, playerid, itemid, gameid FROM player_buy WHERE id = :p0';
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
            /** @var ChildPlayerBuy $obj */
            $obj = new ChildPlayerBuy();
            $obj->hydrate($row);
            PlayerBuyTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlayerBuy|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByPlayerid($playerid = null, $comparison = null)
    {
        if (is_array($playerid)) {
            $useMinMax = false;
            if (isset($playerid['min'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_PLAYERID, $playerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerid['max'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_PLAYERID, $playerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerBuyTableMap::COL_PLAYERID, $playerid, $comparison);
    }

    /**
     * Filter the query on the itemid column
     *
     * Example usage:
     * <code>
     * $query->filterByItemid(1234); // WHERE itemid = 1234
     * $query->filterByItemid(array(12, 34)); // WHERE itemid IN (12, 34)
     * $query->filterByItemid(array('min' => 12)); // WHERE itemid > 12
     * </code>
     *
     * @see       filterByShopitems()
     *
     * @param     mixed $itemid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByItemid($itemid = null, $comparison = null)
    {
        if (is_array($itemid)) {
            $useMinMax = false;
            if (isset($itemid['min'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_ITEMID, $itemid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemid['max'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_ITEMID, $itemid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerBuyTableMap::COL_ITEMID, $itemid, $comparison);
    }

    /**
     * Filter the query on the gameid column
     *
     * Example usage:
     * <code>
     * $query->filterByGameid(1234); // WHERE gameid = 1234
     * $query->filterByGameid(array(12, 34)); // WHERE gameid IN (12, 34)
     * $query->filterByGameid(array('min' => 12)); // WHERE gameid > 12
     * </code>
     *
     * @see       filterByGame()
     *
     * @param     mixed $gameid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByGameid($gameid = null, $comparison = null)
    {
        if (is_array($gameid)) {
            $useMinMax = false;
            if (isset($gameid['min'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_GAMEID, $gameid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameid['max'])) {
                $this->addUsingAlias(PlayerBuyTableMap::COL_GAMEID, $gameid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlayerBuyTableMap::COL_GAMEID, $gameid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Game object
     *
     * @param \Model\Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Model\Game) {
            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_GAMEID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_GAMEID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGame() only accepts arguments of type \Model\Game or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Game relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Game');

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
            $this->addJoinObject($join, 'Game');
        }

        return $this;
    }

    /**
     * Use the Game relation Game object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GameQuery A secondary query class using the current class as primary query
     */
    public function useGameQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\Model\GameQuery');
    }

    /**
     * Use the Game relation Game object
     *
     * @param callable(\Model\GameQuery):\Model\GameQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGameQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGameQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Game table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GameQuery The inner query object of the EXISTS statement
     */
    public function useGameExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Game', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Game table for a NOT EXISTS query.
     *
     * @see useGameExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GameQuery The inner query object of the NOT EXISTS statement
     */
    public function useGameNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Game', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Shopitems object
     *
     * @param \Model\Shopitems|ObjectCollection $shopitems The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByShopitems($shopitems, $comparison = null)
    {
        if ($shopitems instanceof \Model\Shopitems) {
            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_ITEMID, $shopitems->getId(), $comparison);
        } elseif ($shopitems instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_ITEMID, $shopitems->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShopitems() only accepts arguments of type \Model\Shopitems or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Shopitems relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function joinShopitems($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Shopitems');

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
            $this->addJoinObject($join, 'Shopitems');
        }

        return $this;
    }

    /**
     * Use the Shopitems relation Shopitems object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\ShopitemsQuery A secondary query class using the current class as primary query
     */
    public function useShopitemsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinShopitems($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Shopitems', '\Model\ShopitemsQuery');
    }

    /**
     * Use the Shopitems relation Shopitems object
     *
     * @param callable(\Model\ShopitemsQuery):\Model\ShopitemsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withShopitemsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useShopitemsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Shopitems table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\ShopitemsQuery The inner query object of the EXISTS statement
     */
    public function useShopitemsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Shopitems', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Shopitems table for a NOT EXISTS query.
     *
     * @see useShopitemsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\ShopitemsQuery The inner query object of the NOT EXISTS statement
     */
    public function useShopitemsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Shopitems', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Player object
     *
     * @param \Model\Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Model\Player) {
            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_PLAYERID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlayerBuyTableMap::COL_PLAYERID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
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
     * @param   ChildPlayerBuy $playerBuy Object to remove from the list of results
     *
     * @return $this|ChildPlayerBuyQuery The current query, for fluid interface
     */
    public function prune($playerBuy = null)
    {
        if ($playerBuy) {
            $this->addUsingAlias(PlayerBuyTableMap::COL_ID, $playerBuy->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the player_buy table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerBuyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlayerBuyTableMap::clearInstancePool();
            PlayerBuyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerBuyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlayerBuyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlayerBuyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlayerBuyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlayerBuyQuery
