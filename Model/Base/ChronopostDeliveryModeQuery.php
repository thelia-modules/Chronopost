<?php

namespace Chronopost\Model\Base;

use \Exception;
use \PDO;
use Chronopost\Model\ChronopostDeliveryMode as ChildChronopostDeliveryMode;
use Chronopost\Model\ChronopostDeliveryModeQuery as ChildChronopostDeliveryModeQuery;
use Chronopost\Model\Map\ChronopostDeliveryModeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'chronopost_delivery_mode' table.
 *
 *
 *
 * @method     ChildChronopostDeliveryModeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildChronopostDeliveryModeQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildChronopostDeliveryModeQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildChronopostDeliveryModeQuery orderByFreeshippingActive($order = Criteria::ASC) Order by the freeshipping_active column
 * @method     ChildChronopostDeliveryModeQuery orderByFreeshippingFrom($order = Criteria::ASC) Order by the freeshipping_from column
 *
 * @method     ChildChronopostDeliveryModeQuery groupById() Group by the id column
 * @method     ChildChronopostDeliveryModeQuery groupByTitle() Group by the title column
 * @method     ChildChronopostDeliveryModeQuery groupByCode() Group by the code column
 * @method     ChildChronopostDeliveryModeQuery groupByFreeshippingActive() Group by the freeshipping_active column
 * @method     ChildChronopostDeliveryModeQuery groupByFreeshippingFrom() Group by the freeshipping_from column
 *
 * @method     ChildChronopostDeliveryModeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChronopostDeliveryModeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChronopostDeliveryModeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChronopostDeliveryModeQuery leftJoinChronopostPrice($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChronopostPrice relation
 * @method     ChildChronopostDeliveryModeQuery rightJoinChronopostPrice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChronopostPrice relation
 * @method     ChildChronopostDeliveryModeQuery innerJoinChronopostPrice($relationAlias = null) Adds a INNER JOIN clause to the query using the ChronopostPrice relation
 *
 * @method     ChildChronopostDeliveryModeQuery leftJoinChronopostAreaFreeshipping($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChronopostAreaFreeshipping relation
 * @method     ChildChronopostDeliveryModeQuery rightJoinChronopostAreaFreeshipping($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChronopostAreaFreeshipping relation
 * @method     ChildChronopostDeliveryModeQuery innerJoinChronopostAreaFreeshipping($relationAlias = null) Adds a INNER JOIN clause to the query using the ChronopostAreaFreeshipping relation
 *
 * @method     ChildChronopostDeliveryMode findOne(ConnectionInterface $con = null) Return the first ChildChronopostDeliveryMode matching the query
 * @method     ChildChronopostDeliveryMode findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChronopostDeliveryMode matching the query, or a new ChildChronopostDeliveryMode object populated from the query conditions when no match is found
 *
 * @method     ChildChronopostDeliveryMode findOneById(int $id) Return the first ChildChronopostDeliveryMode filtered by the id column
 * @method     ChildChronopostDeliveryMode findOneByTitle(string $title) Return the first ChildChronopostDeliveryMode filtered by the title column
 * @method     ChildChronopostDeliveryMode findOneByCode(string $code) Return the first ChildChronopostDeliveryMode filtered by the code column
 * @method     ChildChronopostDeliveryMode findOneByFreeshippingActive(boolean $freeshipping_active) Return the first ChildChronopostDeliveryMode filtered by the freeshipping_active column
 * @method     ChildChronopostDeliveryMode findOneByFreeshippingFrom(double $freeshipping_from) Return the first ChildChronopostDeliveryMode filtered by the freeshipping_from column
 *
 * @method     array findById(int $id) Return ChildChronopostDeliveryMode objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildChronopostDeliveryMode objects filtered by the title column
 * @method     array findByCode(string $code) Return ChildChronopostDeliveryMode objects filtered by the code column
 * @method     array findByFreeshippingActive(boolean $freeshipping_active) Return ChildChronopostDeliveryMode objects filtered by the freeshipping_active column
 * @method     array findByFreeshippingFrom(double $freeshipping_from) Return ChildChronopostDeliveryMode objects filtered by the freeshipping_from column
 *
 */
abstract class ChronopostDeliveryModeQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Chronopost\Model\Base\ChronopostDeliveryModeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Chronopost\\Model\\ChronopostDeliveryMode', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChronopostDeliveryModeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildChronopostDeliveryModeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Chronopost\Model\ChronopostDeliveryModeQuery) {
            return $criteria;
        }
        $query = new \Chronopost\Model\ChronopostDeliveryModeQuery();
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
     * @return ChildChronopostDeliveryMode|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChronopostDeliveryModeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChronopostDeliveryModeTableMap::DATABASE_NAME);
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
     * @return   ChildChronopostDeliveryMode A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, CODE, FREESHIPPING_ACTIVE, FREESHIPPING_FROM FROM chronopost_delivery_mode WHERE ID = :p0';
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
            $obj = new ChildChronopostDeliveryMode();
            $obj->hydrate($row);
            ChronopostDeliveryModeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildChronopostDeliveryMode|array|mixed the result, formatted by the current formatter
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
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::CODE, $code, $comparison);
    }

    /**
     * Filter the query on the freeshipping_active column
     *
     * Example usage:
     * <code>
     * $query->filterByFreeshippingActive(true); // WHERE freeshipping_active = true
     * $query->filterByFreeshippingActive('yes'); // WHERE freeshipping_active = true
     * </code>
     *
     * @param     boolean|string $freeshippingActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByFreeshippingActive($freeshippingActive = null, $comparison = null)
    {
        if (is_string($freeshippingActive)) {
            $freeshipping_active = in_array(strtolower($freeshippingActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::FREESHIPPING_ACTIVE, $freeshippingActive, $comparison);
    }

    /**
     * Filter the query on the freeshipping_from column
     *
     * Example usage:
     * <code>
     * $query->filterByFreeshippingFrom(1234); // WHERE freeshipping_from = 1234
     * $query->filterByFreeshippingFrom(array(12, 34)); // WHERE freeshipping_from IN (12, 34)
     * $query->filterByFreeshippingFrom(array('min' => 12)); // WHERE freeshipping_from > 12
     * </code>
     *
     * @param     mixed $freeshippingFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByFreeshippingFrom($freeshippingFrom = null, $comparison = null)
    {
        if (is_array($freeshippingFrom)) {
            $useMinMax = false;
            if (isset($freeshippingFrom['min'])) {
                $this->addUsingAlias(ChronopostDeliveryModeTableMap::FREESHIPPING_FROM, $freeshippingFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($freeshippingFrom['max'])) {
                $this->addUsingAlias(ChronopostDeliveryModeTableMap::FREESHIPPING_FROM, $freeshippingFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChronopostDeliveryModeTableMap::FREESHIPPING_FROM, $freeshippingFrom, $comparison);
    }

    /**
     * Filter the query by a related \Chronopost\Model\ChronopostPrice object
     *
     * @param \Chronopost\Model\ChronopostPrice|ObjectCollection $chronopostPrice  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByChronopostPrice($chronopostPrice, $comparison = null)
    {
        if ($chronopostPrice instanceof \Chronopost\Model\ChronopostPrice) {
            return $this
                ->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $chronopostPrice->getDeliveryModeId(), $comparison);
        } elseif ($chronopostPrice instanceof ObjectCollection) {
            return $this
                ->useChronopostPriceQuery()
                ->filterByPrimaryKeys($chronopostPrice->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChronopostPrice() only accepts arguments of type \Chronopost\Model\ChronopostPrice or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChronopostPrice relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function joinChronopostPrice($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChronopostPrice');

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
            $this->addJoinObject($join, 'ChronopostPrice');
        }

        return $this;
    }

    /**
     * Use the ChronopostPrice relation ChronopostPrice object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Chronopost\Model\ChronopostPriceQuery A secondary query class using the current class as primary query
     */
    public function useChronopostPriceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChronopostPrice($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChronopostPrice', '\Chronopost\Model\ChronopostPriceQuery');
    }

    /**
     * Filter the query by a related \Chronopost\Model\ChronopostAreaFreeshipping object
     *
     * @param \Chronopost\Model\ChronopostAreaFreeshipping|ObjectCollection $chronopostAreaFreeshipping  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function filterByChronopostAreaFreeshipping($chronopostAreaFreeshipping, $comparison = null)
    {
        if ($chronopostAreaFreeshipping instanceof \Chronopost\Model\ChronopostAreaFreeshipping) {
            return $this
                ->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $chronopostAreaFreeshipping->getDeliveryModeId(), $comparison);
        } elseif ($chronopostAreaFreeshipping instanceof ObjectCollection) {
            return $this
                ->useChronopostAreaFreeshippingQuery()
                ->filterByPrimaryKeys($chronopostAreaFreeshipping->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChronopostAreaFreeshipping() only accepts arguments of type \Chronopost\Model\ChronopostAreaFreeshipping or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChronopostAreaFreeshipping relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function joinChronopostAreaFreeshipping($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChronopostAreaFreeshipping');

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
            $this->addJoinObject($join, 'ChronopostAreaFreeshipping');
        }

        return $this;
    }

    /**
     * Use the ChronopostAreaFreeshipping relation ChronopostAreaFreeshipping object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Chronopost\Model\ChronopostAreaFreeshippingQuery A secondary query class using the current class as primary query
     */
    public function useChronopostAreaFreeshippingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChronopostAreaFreeshipping($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChronopostAreaFreeshipping', '\Chronopost\Model\ChronopostAreaFreeshippingQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildChronopostDeliveryMode $chronopostDeliveryMode Object to remove from the list of results
     *
     * @return ChildChronopostDeliveryModeQuery The current query, for fluid interface
     */
    public function prune($chronopostDeliveryMode = null)
    {
        if ($chronopostDeliveryMode) {
            $this->addUsingAlias(ChronopostDeliveryModeTableMap::ID, $chronopostDeliveryMode->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the chronopost_delivery_mode table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostDeliveryModeTableMap::DATABASE_NAME);
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
            ChronopostDeliveryModeTableMap::clearInstancePool();
            ChronopostDeliveryModeTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildChronopostDeliveryMode or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildChronopostDeliveryMode object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostDeliveryModeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChronopostDeliveryModeTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ChronopostDeliveryModeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChronopostDeliveryModeTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ChronopostDeliveryModeQuery
