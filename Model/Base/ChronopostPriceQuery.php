<?php

namespace Chronopost\Model\Base;

use \Exception;
use \PDO;
use Chronopost\Model\ChronopostPrice as ChildChronopostPrice;
use Chronopost\Model\ChronopostPriceQuery as ChildChronopostPriceQuery;
use Chronopost\Model\Map\ChronopostPriceTableMap;
use Chronopost\Model\Thelia\Model\Area;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'chronopost_price' table.
 *
 *
 *
 * @method     ChildChronopostPriceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildChronopostPriceQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method     ChildChronopostPriceQuery orderByDeliveryModeId($order = Criteria::ASC) Order by the delivery_mode_id column
 * @method     ChildChronopostPriceQuery orderByWeightMax($order = Criteria::ASC) Order by the weight_max column
 * @method     ChildChronopostPriceQuery orderByPriceMax($order = Criteria::ASC) Order by the price_max column
 * @method     ChildChronopostPriceQuery orderByFrancoMinPrice($order = Criteria::ASC) Order by the franco_min_price column
 * @method     ChildChronopostPriceQuery orderByPrice($order = Criteria::ASC) Order by the price column
 *
 * @method     ChildChronopostPriceQuery groupById() Group by the id column
 * @method     ChildChronopostPriceQuery groupByAreaId() Group by the area_id column
 * @method     ChildChronopostPriceQuery groupByDeliveryModeId() Group by the delivery_mode_id column
 * @method     ChildChronopostPriceQuery groupByWeightMax() Group by the weight_max column
 * @method     ChildChronopostPriceQuery groupByPriceMax() Group by the price_max column
 * @method     ChildChronopostPriceQuery groupByFrancoMinPrice() Group by the franco_min_price column
 * @method     ChildChronopostPriceQuery groupByPrice() Group by the price column
 *
 * @method     ChildChronopostPriceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChronopostPriceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChronopostPriceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChronopostPriceQuery leftJoinArea($relationAlias = null) Adds a LEFT JOIN clause to the query using the Area relation
 * @method     ChildChronopostPriceQuery rightJoinArea($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Area relation
 * @method     ChildChronopostPriceQuery innerJoinArea($relationAlias = null) Adds a INNER JOIN clause to the query using the Area relation
 *
 * @method     ChildChronopostPriceQuery leftJoinChronopostDeliveryMode($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChronopostDeliveryMode relation
 * @method     ChildChronopostPriceQuery rightJoinChronopostDeliveryMode($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChronopostDeliveryMode relation
 * @method     ChildChronopostPriceQuery innerJoinChronopostDeliveryMode($relationAlias = null) Adds a INNER JOIN clause to the query using the ChronopostDeliveryMode relation
 *
 * @method     ChildChronopostPrice findOne(ConnectionInterface $con = null) Return the first ChildChronopostPrice matching the query
 * @method     ChildChronopostPrice findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChronopostPrice matching the query, or a new ChildChronopostPrice object populated from the query conditions when no match is found
 *
 * @method     ChildChronopostPrice findOneById(int $id) Return the first ChildChronopostPrice filtered by the id column
 * @method     ChildChronopostPrice findOneByAreaId(int $area_id) Return the first ChildChronopostPrice filtered by the area_id column
 * @method     ChildChronopostPrice findOneByDeliveryModeId(int $delivery_mode_id) Return the first ChildChronopostPrice filtered by the delivery_mode_id column
 * @method     ChildChronopostPrice findOneByWeightMax(double $weight_max) Return the first ChildChronopostPrice filtered by the weight_max column
 * @method     ChildChronopostPrice findOneByPriceMax(double $price_max) Return the first ChildChronopostPrice filtered by the price_max column
 * @method     ChildChronopostPrice findOneByFrancoMinPrice(double $franco_min_price) Return the first ChildChronopostPrice filtered by the franco_min_price column
 * @method     ChildChronopostPrice findOneByPrice(double $price) Return the first ChildChronopostPrice filtered by the price column
 *
 * @method     array findById(int $id) Return ChildChronopostPrice objects filtered by the id column
 * @method     array findByAreaId(int $area_id) Return ChildChronopostPrice objects filtered by the area_id column
 * @method     array findByDeliveryModeId(int $delivery_mode_id) Return ChildChronopostPrice objects filtered by the delivery_mode_id column
 * @method     array findByWeightMax(double $weight_max) Return ChildChronopostPrice objects filtered by the weight_max column
 * @method     array findByPriceMax(double $price_max) Return ChildChronopostPrice objects filtered by the price_max column
 * @method     array findByFrancoMinPrice(double $franco_min_price) Return ChildChronopostPrice objects filtered by the franco_min_price column
 * @method     array findByPrice(double $price) Return ChildChronopostPrice objects filtered by the price column
 *
 */
abstract class ChronopostPriceQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Chronopost\Model\Base\ChronopostPriceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Chronopost\\Model\\ChronopostPrice', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChronopostPriceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildChronopostPriceQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Chronopost\Model\ChronopostPriceQuery) {
            return $criteria;
        }
        $query = new \Chronopost\Model\ChronopostPriceQuery();
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
     * @return ChildChronopostPrice|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChronopostPriceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChronopostPriceTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildChronopostPrice A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, AREA_ID, DELIVERY_MODE_ID, WEIGHT_MAX, PRICE_MAX, FRANCO_MIN_PRICE, PRICE FROM chronopost_price WHERE ID = :p0';
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
            $obj = new ChildChronopostPrice();
            $obj->hydrate($row);
            ChronopostPriceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildChronopostPrice|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChronopostPriceTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChronopostPriceTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the area_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAreaId(1234); // WHERE area_id = 1234
     * $query->filterByAreaId(array(12, 34)); // WHERE area_id IN (12, 34)
     * $query->filterByAreaId(array('min' => 12)); // WHERE area_id > 12
     * </code>
     *
     * @see       filterByArea()
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::AREA_ID, $areaId, $comparison);
    }

    /**
     * Filter the query on the delivery_mode_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryModeId(1234); // WHERE delivery_mode_id = 1234
     * $query->filterByDeliveryModeId(array(12, 34)); // WHERE delivery_mode_id IN (12, 34)
     * $query->filterByDeliveryModeId(array('min' => 12)); // WHERE delivery_mode_id > 12
     * </code>
     *
     * @see       filterByChronopostDeliveryMode()
     *
     * @param     mixed $deliveryModeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByDeliveryModeId($deliveryModeId = null, $comparison = null)
    {
        if (is_array($deliveryModeId)) {
            $useMinMax = false;
            if (isset($deliveryModeId['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::DELIVERY_MODE_ID, $deliveryModeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryModeId['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::DELIVERY_MODE_ID, $deliveryModeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::DELIVERY_MODE_ID, $deliveryModeId, $comparison);
    }

    /**
     * Filter the query on the weight_max column
     *
     * Example usage:
     * <code>
     * $query->filterByWeightMax(1234); // WHERE weight_max = 1234
     * $query->filterByWeightMax(array(12, 34)); // WHERE weight_max IN (12, 34)
     * $query->filterByWeightMax(array('min' => 12)); // WHERE weight_max > 12
     * </code>
     *
     * @param     mixed $weightMax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByWeightMax($weightMax = null, $comparison = null)
    {
        if (is_array($weightMax)) {
            $useMinMax = false;
            if (isset($weightMax['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::WEIGHT_MAX, $weightMax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weightMax['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::WEIGHT_MAX, $weightMax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::WEIGHT_MAX, $weightMax, $comparison);
    }

    /**
     * Filter the query on the price_max column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceMax(1234); // WHERE price_max = 1234
     * $query->filterByPriceMax(array(12, 34)); // WHERE price_max IN (12, 34)
     * $query->filterByPriceMax(array('min' => 12)); // WHERE price_max > 12
     * </code>
     *
     * @param     mixed $priceMax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByPriceMax($priceMax = null, $comparison = null)
    {
        if (is_array($priceMax)) {
            $useMinMax = false;
            if (isset($priceMax['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::PRICE_MAX, $priceMax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceMax['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::PRICE_MAX, $priceMax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::PRICE_MAX, $priceMax, $comparison);
    }

    /**
     * Filter the query on the franco_min_price column
     *
     * Example usage:
     * <code>
     * $query->filterByFrancoMinPrice(1234); // WHERE franco_min_price = 1234
     * $query->filterByFrancoMinPrice(array(12, 34)); // WHERE franco_min_price IN (12, 34)
     * $query->filterByFrancoMinPrice(array('min' => 12)); // WHERE franco_min_price > 12
     * </code>
     *
     * @param     mixed $francoMinPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByFrancoMinPrice($francoMinPrice = null, $comparison = null)
    {
        if (is_array($francoMinPrice)) {
            $useMinMax = false;
            if (isset($francoMinPrice['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::FRANCO_MIN_PRICE, $francoMinPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($francoMinPrice['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::FRANCO_MIN_PRICE, $francoMinPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::FRANCO_MIN_PRICE, $francoMinPrice, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(ChronopostPriceTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostPriceTableMap::PRICE, $price, $comparison);
    }

    /**
     * Filter the query by a related \Chronopost\Model\Thelia\Model\Area object
     *
     * @param \Chronopost\Model\Thelia\Model\Area|ObjectCollection $area The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByArea($area, $comparison = null)
    {
        if ($area instanceof \Chronopost\Model\Thelia\Model\Area) {
            return $this
                ->addUsingAlias(ChronopostPriceTableMap::AREA_ID, $area->getId(), $comparison);
        } elseif ($area instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ChronopostPriceTableMap::AREA_ID, $area->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByArea() only accepts arguments of type \Chronopost\Model\Thelia\Model\Area or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Area relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function joinArea($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Area');

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
            $this->addJoinObject($join, 'Area');
        }

        return $this;
    }

    /**
     * Use the Area relation Area object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Chronopost\Model\Thelia\Model\AreaQuery A secondary query class using the current class as primary query
     */
    public function useAreaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArea($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Area', '\Chronopost\Model\Thelia\Model\AreaQuery');
    }

    /**
     * Filter the query by a related \Chronopost\Model\ChronopostDeliveryMode object
     *
     * @param \Chronopost\Model\ChronopostDeliveryMode|ObjectCollection $chronopostDeliveryMode The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function filterByChronopostDeliveryMode($chronopostDeliveryMode, $comparison = null)
    {
        if ($chronopostDeliveryMode instanceof \Chronopost\Model\ChronopostDeliveryMode) {
            return $this
                ->addUsingAlias(ChronopostPriceTableMap::DELIVERY_MODE_ID, $chronopostDeliveryMode->getId(), $comparison);
        } elseif ($chronopostDeliveryMode instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ChronopostPriceTableMap::DELIVERY_MODE_ID, $chronopostDeliveryMode->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByChronopostDeliveryMode() only accepts arguments of type \Chronopost\Model\ChronopostDeliveryMode or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChronopostDeliveryMode relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function joinChronopostDeliveryMode($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChronopostDeliveryMode');

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
            $this->addJoinObject($join, 'ChronopostDeliveryMode');
        }

        return $this;
    }

    /**
     * Use the ChronopostDeliveryMode relation ChronopostDeliveryMode object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Chronopost\Model\ChronopostDeliveryModeQuery A secondary query class using the current class as primary query
     */
    public function useChronopostDeliveryModeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChronopostDeliveryMode($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChronopostDeliveryMode', '\Chronopost\Model\ChronopostDeliveryModeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildChronopostPrice $chronopostPrice Object to remove from the list of results
     *
     * @return ChildChronopostPriceQuery The current query, for fluid interface
     */
    public function prune($chronopostPrice = null)
    {
        if ($chronopostPrice) {
            $this->addUsingAlias(ChronopostPriceTableMap::ID, $chronopostPrice->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the chronopost_price table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostPriceTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ChronopostPriceTableMap::clearInstancePool();
            ChronopostPriceTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildChronopostPrice or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildChronopostPrice object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostPriceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChronopostPriceTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ChronopostPriceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChronopostPriceTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ChronopostPriceQuery
