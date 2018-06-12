<?php

namespace Chronopost\Model\Base;

use \Exception;
use \PDO;
use Chronopost\Model\ChronopostAreaFreeshipping as ChildChronopostAreaFreeshipping;
use Chronopost\Model\ChronopostAreaFreeshippingQuery as ChildChronopostAreaFreeshippingQuery;
use Chronopost\Model\ChronopostDeliveryType as ChildChronopostDeliveryType;
use Chronopost\Model\ChronopostDeliveryTypeQuery as ChildChronopostDeliveryTypeQuery;
use Chronopost\Model\ChronopostPrice as ChildChronopostPrice;
use Chronopost\Model\ChronopostPriceQuery as ChildChronopostPriceQuery;
use Chronopost\Model\Map\ChronopostDeliveryTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class ChronopostDeliveryType implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Chronopost\\Model\\Map\\ChronopostDeliveryTypeTableMap';


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
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

    /**
     * The value for the freeshipping_active field.
     * @var        boolean
     */
    protected $freeshipping_active;

    /**
     * The value for the freeshipping_from field.
     * @var        double
     */
    protected $freeshipping_from;

    /**
     * @var        ObjectCollection|ChildChronopostPrice[] Collection to store aggregation of ChildChronopostPrice objects.
     */
    protected $collChronopostPrices;
    protected $collChronopostPricesPartial;

    /**
     * @var        ObjectCollection|ChildChronopostAreaFreeshipping[] Collection to store aggregation of ChildChronopostAreaFreeshipping objects.
     */
    protected $collChronopostAreaFreeshippings;
    protected $collChronopostAreaFreeshippingsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $chronopostPricesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $chronopostAreaFreeshippingsScheduledForDeletion = null;

    /**
     * Initializes internal state of Chronopost\Model\Base\ChronopostDeliveryType object.
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
        $this->new = (Boolean) $b;
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
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>ChronopostDeliveryType</code> instance.  If
     * <code>obj</code> is an instance of <code>ChronopostDeliveryType</code>, delegates to
     * <code>equals(ChronopostDeliveryType)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
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
     * @return ChronopostDeliveryType The current object, for fluid interface
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
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return ChronopostDeliveryType The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
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
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return   string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [code] column value.
     *
     * @return   string
     */
    public function getCode()
    {

        return $this->code;
    }

    /**
     * Get the [freeshipping_active] column value.
     *
     * @return   boolean
     */
    public function getFreeshippingActive()
    {

        return $this->freeshipping_active;
    }

    /**
     * Get the [freeshipping_from] column value.
     *
     * @return   double
     */
    public function getFreeshippingFrom()
    {

        return $this->freeshipping_from;
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ChronopostDeliveryTypeTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param      string $v new value
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[ChronopostDeliveryTypeTableMap::TITLE] = true;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [code] column.
     *
     * @param      string $v new value
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[ChronopostDeliveryTypeTableMap::CODE] = true;
        }


        return $this;
    } // setCode()

    /**
     * Sets the value of the [freeshipping_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param      boolean|integer|string $v The new value
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function setFreeshippingActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->freeshipping_active !== $v) {
            $this->freeshipping_active = $v;
            $this->modifiedColumns[ChronopostDeliveryTypeTableMap::FREESHIPPING_ACTIVE] = true;
        }


        return $this;
    } // setFreeshippingActive()

    /**
     * Set the value of [freeshipping_from] column.
     *
     * @param      double $v new value
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function setFreeshippingFrom($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->freeshipping_from !== $v) {
            $this->freeshipping_from = $v;
            $this->modifiedColumns[ChronopostDeliveryTypeTableMap::FREESHIPPING_FROM] = true;
        }


        return $this;
    } // setFreeshippingFrom()

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
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ChronopostDeliveryTypeTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ChronopostDeliveryTypeTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ChronopostDeliveryTypeTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ChronopostDeliveryTypeTableMap::translateFieldName('FreeshippingActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->freeshipping_active = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ChronopostDeliveryTypeTableMap::translateFieldName('FreeshippingFrom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->freeshipping_from = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ChronopostDeliveryTypeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Chronopost\Model\ChronopostDeliveryType object", 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ChronopostDeliveryTypeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildChronopostDeliveryTypeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collChronopostPrices = null;

            $this->collChronopostAreaFreeshippings = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ChronopostDeliveryType::setDeleted()
     * @see ChronopostDeliveryType::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostDeliveryTypeTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildChronopostDeliveryTypeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
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

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostDeliveryTypeTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
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
                ChronopostDeliveryTypeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
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
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->chronopostPricesScheduledForDeletion !== null) {
                if (!$this->chronopostPricesScheduledForDeletion->isEmpty()) {
                    \Chronopost\Model\ChronopostPriceQuery::create()
                        ->filterByPrimaryKeys($this->chronopostPricesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->chronopostPricesScheduledForDeletion = null;
                }
            }

                if ($this->collChronopostPrices !== null) {
            foreach ($this->collChronopostPrices as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->chronopostAreaFreeshippingsScheduledForDeletion !== null) {
                if (!$this->chronopostAreaFreeshippingsScheduledForDeletion->isEmpty()) {
                    \Chronopost\Model\ChronopostAreaFreeshippingQuery::create()
                        ->filterByPrimaryKeys($this->chronopostAreaFreeshippingsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->chronopostAreaFreeshippingsScheduledForDeletion = null;
                }
            }

                if ($this->collChronopostAreaFreeshippings !== null) {
            foreach ($this->collChronopostAreaFreeshippings as $referrerFK) {
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

        $this->modifiedColumns[ChronopostDeliveryTypeTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ChronopostDeliveryTypeTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'TITLE';
        }
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::CODE)) {
            $modifiedColumns[':p' . $index++]  = 'CODE';
        }
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::FREESHIPPING_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'FREESHIPPING_ACTIVE';
        }
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::FREESHIPPING_FROM)) {
            $modifiedColumns[':p' . $index++]  = 'FREESHIPPING_FROM';
        }

        $sql = sprintf(
            'INSERT INTO chronopost_delivery_type (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'TITLE':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'CODE':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'FREESHIPPING_ACTIVE':
                        $stmt->bindValue($identifier, (int) $this->freeshipping_active, PDO::PARAM_INT);
                        break;
                    case 'FREESHIPPING_FROM':
                        $stmt->bindValue($identifier, $this->freeshipping_from, PDO::PARAM_STR);
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
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ChronopostDeliveryTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTitle();
                break;
            case 2:
                return $this->getCode();
                break;
            case 3:
                return $this->getFreeshippingActive();
                break;
            case 4:
                return $this->getFreeshippingFrom();
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
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
        if (isset($alreadyDumpedObjects['ChronopostDeliveryType'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ChronopostDeliveryType'][$this->getPrimaryKey()] = true;
        $keys = ChronopostDeliveryTypeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getFreeshippingActive(),
            $keys[4] => $this->getFreeshippingFrom(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collChronopostPrices) {
                $result['ChronopostPrices'] = $this->collChronopostPrices->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collChronopostAreaFreeshippings) {
                $result['ChronopostAreaFreeshippings'] = $this->collChronopostAreaFreeshippings->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ChronopostDeliveryTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setCode($value);
                break;
            case 3:
                $this->setFreeshippingActive($value);
                break;
            case 4:
                $this->setFreeshippingFrom($value);
                break;
        } // switch()
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ChronopostDeliveryTypeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setCode($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFreeshippingActive($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setFreeshippingFrom($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ChronopostDeliveryTypeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::ID)) $criteria->add(ChronopostDeliveryTypeTableMap::ID, $this->id);
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::TITLE)) $criteria->add(ChronopostDeliveryTypeTableMap::TITLE, $this->title);
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::CODE)) $criteria->add(ChronopostDeliveryTypeTableMap::CODE, $this->code);
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::FREESHIPPING_ACTIVE)) $criteria->add(ChronopostDeliveryTypeTableMap::FREESHIPPING_ACTIVE, $this->freeshipping_active);
        if ($this->isColumnModified(ChronopostDeliveryTypeTableMap::FREESHIPPING_FROM)) $criteria->add(ChronopostDeliveryTypeTableMap::FREESHIPPING_FROM, $this->freeshipping_from);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ChronopostDeliveryTypeTableMap::DATABASE_NAME);
        $criteria->add(ChronopostDeliveryTypeTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
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
     * @param      object $copyObj An object of \Chronopost\Model\ChronopostDeliveryType (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setCode($this->getCode());
        $copyObj->setFreeshippingActive($this->getFreeshippingActive());
        $copyObj->setFreeshippingFrom($this->getFreeshippingFrom());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getChronopostPrices() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChronopostPrice($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getChronopostAreaFreeshippings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChronopostAreaFreeshipping($relObj->copy($deepCopy));
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
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Chronopost\Model\ChronopostDeliveryType Clone of current object.
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
        if ('ChronopostPrice' == $relationName) {
            return $this->initChronopostPrices();
        }
        if ('ChronopostAreaFreeshipping' == $relationName) {
            return $this->initChronopostAreaFreeshippings();
        }
    }

    /**
     * Clears out the collChronopostPrices collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addChronopostPrices()
     */
    public function clearChronopostPrices()
    {
        $this->collChronopostPrices = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collChronopostPrices collection loaded partially.
     */
    public function resetPartialChronopostPrices($v = true)
    {
        $this->collChronopostPricesPartial = $v;
    }

    /**
     * Initializes the collChronopostPrices collection.
     *
     * By default this just sets the collChronopostPrices collection to an empty array (like clearcollChronopostPrices());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChronopostPrices($overrideExisting = true)
    {
        if (null !== $this->collChronopostPrices && !$overrideExisting) {
            return;
        }
        $this->collChronopostPrices = new ObjectCollection();
        $this->collChronopostPrices->setModel('\Chronopost\Model\ChronopostPrice');
    }

    /**
     * Gets an array of ChildChronopostPrice objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChronopostDeliveryType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildChronopostPrice[] List of ChildChronopostPrice objects
     * @throws PropelException
     */
    public function getChronopostPrices($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collChronopostPricesPartial && !$this->isNew();
        if (null === $this->collChronopostPrices || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChronopostPrices) {
                // return empty collection
                $this->initChronopostPrices();
            } else {
                $collChronopostPrices = ChildChronopostPriceQuery::create(null, $criteria)
                    ->filterByChronopostDeliveryType($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collChronopostPricesPartial && count($collChronopostPrices)) {
                        $this->initChronopostPrices(false);

                        foreach ($collChronopostPrices as $obj) {
                            if (false == $this->collChronopostPrices->contains($obj)) {
                                $this->collChronopostPrices->append($obj);
                            }
                        }

                        $this->collChronopostPricesPartial = true;
                    }

                    reset($collChronopostPrices);

                    return $collChronopostPrices;
                }

                if ($partial && $this->collChronopostPrices) {
                    foreach ($this->collChronopostPrices as $obj) {
                        if ($obj->isNew()) {
                            $collChronopostPrices[] = $obj;
                        }
                    }
                }

                $this->collChronopostPrices = $collChronopostPrices;
                $this->collChronopostPricesPartial = false;
            }
        }

        return $this->collChronopostPrices;
    }

    /**
     * Sets a collection of ChronopostPrice objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $chronopostPrices A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildChronopostDeliveryType The current object (for fluent API support)
     */
    public function setChronopostPrices(Collection $chronopostPrices, ConnectionInterface $con = null)
    {
        $chronopostPricesToDelete = $this->getChronopostPrices(new Criteria(), $con)->diff($chronopostPrices);


        $this->chronopostPricesScheduledForDeletion = $chronopostPricesToDelete;

        foreach ($chronopostPricesToDelete as $chronopostPriceRemoved) {
            $chronopostPriceRemoved->setChronopostDeliveryType(null);
        }

        $this->collChronopostPrices = null;
        foreach ($chronopostPrices as $chronopostPrice) {
            $this->addChronopostPrice($chronopostPrice);
        }

        $this->collChronopostPrices = $chronopostPrices;
        $this->collChronopostPricesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ChronopostPrice objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ChronopostPrice objects.
     * @throws PropelException
     */
    public function countChronopostPrices(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collChronopostPricesPartial && !$this->isNew();
        if (null === $this->collChronopostPrices || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChronopostPrices) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getChronopostPrices());
            }

            $query = ChildChronopostPriceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChronopostDeliveryType($this)
                ->count($con);
        }

        return count($this->collChronopostPrices);
    }

    /**
     * Method called to associate a ChildChronopostPrice object to this object
     * through the ChildChronopostPrice foreign key attribute.
     *
     * @param    ChildChronopostPrice $l ChildChronopostPrice
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function addChronopostPrice(ChildChronopostPrice $l)
    {
        if ($this->collChronopostPrices === null) {
            $this->initChronopostPrices();
            $this->collChronopostPricesPartial = true;
        }

        if (!in_array($l, $this->collChronopostPrices->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddChronopostPrice($l);
        }

        return $this;
    }

    /**
     * @param ChronopostPrice $chronopostPrice The chronopostPrice object to add.
     */
    protected function doAddChronopostPrice($chronopostPrice)
    {
        $this->collChronopostPrices[]= $chronopostPrice;
        $chronopostPrice->setChronopostDeliveryType($this);
    }

    /**
     * @param  ChronopostPrice $chronopostPrice The chronopostPrice object to remove.
     * @return ChildChronopostDeliveryType The current object (for fluent API support)
     */
    public function removeChronopostPrice($chronopostPrice)
    {
        if ($this->getChronopostPrices()->contains($chronopostPrice)) {
            $this->collChronopostPrices->remove($this->collChronopostPrices->search($chronopostPrice));
            if (null === $this->chronopostPricesScheduledForDeletion) {
                $this->chronopostPricesScheduledForDeletion = clone $this->collChronopostPrices;
                $this->chronopostPricesScheduledForDeletion->clear();
            }
            $this->chronopostPricesScheduledForDeletion[]= clone $chronopostPrice;
            $chronopostPrice->setChronopostDeliveryType(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ChronopostDeliveryType is new, it will return
     * an empty collection; or if this ChronopostDeliveryType has previously
     * been saved, it will retrieve related ChronopostPrices from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ChronopostDeliveryType.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildChronopostPrice[] List of ChildChronopostPrice objects
     */
    public function getChronopostPricesJoinArea($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildChronopostPriceQuery::create(null, $criteria);
        $query->joinWith('Area', $joinBehavior);

        return $this->getChronopostPrices($query, $con);
    }

    /**
     * Clears out the collChronopostAreaFreeshippings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addChronopostAreaFreeshippings()
     */
    public function clearChronopostAreaFreeshippings()
    {
        $this->collChronopostAreaFreeshippings = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collChronopostAreaFreeshippings collection loaded partially.
     */
    public function resetPartialChronopostAreaFreeshippings($v = true)
    {
        $this->collChronopostAreaFreeshippingsPartial = $v;
    }

    /**
     * Initializes the collChronopostAreaFreeshippings collection.
     *
     * By default this just sets the collChronopostAreaFreeshippings collection to an empty array (like clearcollChronopostAreaFreeshippings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChronopostAreaFreeshippings($overrideExisting = true)
    {
        if (null !== $this->collChronopostAreaFreeshippings && !$overrideExisting) {
            return;
        }
        $this->collChronopostAreaFreeshippings = new ObjectCollection();
        $this->collChronopostAreaFreeshippings->setModel('\Chronopost\Model\ChronopostAreaFreeshipping');
    }

    /**
     * Gets an array of ChildChronopostAreaFreeshipping objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChronopostDeliveryType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildChronopostAreaFreeshipping[] List of ChildChronopostAreaFreeshipping objects
     * @throws PropelException
     */
    public function getChronopostAreaFreeshippings($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collChronopostAreaFreeshippingsPartial && !$this->isNew();
        if (null === $this->collChronopostAreaFreeshippings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChronopostAreaFreeshippings) {
                // return empty collection
                $this->initChronopostAreaFreeshippings();
            } else {
                $collChronopostAreaFreeshippings = ChildChronopostAreaFreeshippingQuery::create(null, $criteria)
                    ->filterByChronopostDeliveryType($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collChronopostAreaFreeshippingsPartial && count($collChronopostAreaFreeshippings)) {
                        $this->initChronopostAreaFreeshippings(false);

                        foreach ($collChronopostAreaFreeshippings as $obj) {
                            if (false == $this->collChronopostAreaFreeshippings->contains($obj)) {
                                $this->collChronopostAreaFreeshippings->append($obj);
                            }
                        }

                        $this->collChronopostAreaFreeshippingsPartial = true;
                    }

                    reset($collChronopostAreaFreeshippings);

                    return $collChronopostAreaFreeshippings;
                }

                if ($partial && $this->collChronopostAreaFreeshippings) {
                    foreach ($this->collChronopostAreaFreeshippings as $obj) {
                        if ($obj->isNew()) {
                            $collChronopostAreaFreeshippings[] = $obj;
                        }
                    }
                }

                $this->collChronopostAreaFreeshippings = $collChronopostAreaFreeshippings;
                $this->collChronopostAreaFreeshippingsPartial = false;
            }
        }

        return $this->collChronopostAreaFreeshippings;
    }

    /**
     * Sets a collection of ChronopostAreaFreeshipping objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $chronopostAreaFreeshippings A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildChronopostDeliveryType The current object (for fluent API support)
     */
    public function setChronopostAreaFreeshippings(Collection $chronopostAreaFreeshippings, ConnectionInterface $con = null)
    {
        $chronopostAreaFreeshippingsToDelete = $this->getChronopostAreaFreeshippings(new Criteria(), $con)->diff($chronopostAreaFreeshippings);


        $this->chronopostAreaFreeshippingsScheduledForDeletion = $chronopostAreaFreeshippingsToDelete;

        foreach ($chronopostAreaFreeshippingsToDelete as $chronopostAreaFreeshippingRemoved) {
            $chronopostAreaFreeshippingRemoved->setChronopostDeliveryType(null);
        }

        $this->collChronopostAreaFreeshippings = null;
        foreach ($chronopostAreaFreeshippings as $chronopostAreaFreeshipping) {
            $this->addChronopostAreaFreeshipping($chronopostAreaFreeshipping);
        }

        $this->collChronopostAreaFreeshippings = $chronopostAreaFreeshippings;
        $this->collChronopostAreaFreeshippingsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ChronopostAreaFreeshipping objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ChronopostAreaFreeshipping objects.
     * @throws PropelException
     */
    public function countChronopostAreaFreeshippings(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collChronopostAreaFreeshippingsPartial && !$this->isNew();
        if (null === $this->collChronopostAreaFreeshippings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChronopostAreaFreeshippings) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getChronopostAreaFreeshippings());
            }

            $query = ChildChronopostAreaFreeshippingQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChronopostDeliveryType($this)
                ->count($con);
        }

        return count($this->collChronopostAreaFreeshippings);
    }

    /**
     * Method called to associate a ChildChronopostAreaFreeshipping object to this object
     * through the ChildChronopostAreaFreeshipping foreign key attribute.
     *
     * @param    ChildChronopostAreaFreeshipping $l ChildChronopostAreaFreeshipping
     * @return   \Chronopost\Model\ChronopostDeliveryType The current object (for fluent API support)
     */
    public function addChronopostAreaFreeshipping(ChildChronopostAreaFreeshipping $l)
    {
        if ($this->collChronopostAreaFreeshippings === null) {
            $this->initChronopostAreaFreeshippings();
            $this->collChronopostAreaFreeshippingsPartial = true;
        }

        if (!in_array($l, $this->collChronopostAreaFreeshippings->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddChronopostAreaFreeshipping($l);
        }

        return $this;
    }

    /**
     * @param ChronopostAreaFreeshipping $chronopostAreaFreeshipping The chronopostAreaFreeshipping object to add.
     */
    protected function doAddChronopostAreaFreeshipping($chronopostAreaFreeshipping)
    {
        $this->collChronopostAreaFreeshippings[]= $chronopostAreaFreeshipping;
        $chronopostAreaFreeshipping->setChronopostDeliveryType($this);
    }

    /**
     * @param  ChronopostAreaFreeshipping $chronopostAreaFreeshipping The chronopostAreaFreeshipping object to remove.
     * @return ChildChronopostDeliveryType The current object (for fluent API support)
     */
    public function removeChronopostAreaFreeshipping($chronopostAreaFreeshipping)
    {
        if ($this->getChronopostAreaFreeshippings()->contains($chronopostAreaFreeshipping)) {
            $this->collChronopostAreaFreeshippings->remove($this->collChronopostAreaFreeshippings->search($chronopostAreaFreeshipping));
            if (null === $this->chronopostAreaFreeshippingsScheduledForDeletion) {
                $this->chronopostAreaFreeshippingsScheduledForDeletion = clone $this->collChronopostAreaFreeshippings;
                $this->chronopostAreaFreeshippingsScheduledForDeletion->clear();
            }
            $this->chronopostAreaFreeshippingsScheduledForDeletion[]= clone $chronopostAreaFreeshipping;
            $chronopostAreaFreeshipping->setChronopostDeliveryType(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ChronopostDeliveryType is new, it will return
     * an empty collection; or if this ChronopostDeliveryType has previously
     * been saved, it will retrieve related ChronopostAreaFreeshippings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ChronopostDeliveryType.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildChronopostAreaFreeshipping[] List of ChildChronopostAreaFreeshipping objects
     */
    public function getChronopostAreaFreeshippingsJoinArea($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildChronopostAreaFreeshippingQuery::create(null, $criteria);
        $query->joinWith('Area', $joinBehavior);

        return $this->getChronopostAreaFreeshippings($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->title = null;
        $this->code = null;
        $this->freeshipping_active = null;
        $this->freeshipping_from = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collChronopostPrices) {
                foreach ($this->collChronopostPrices as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collChronopostAreaFreeshippings) {
                foreach ($this->collChronopostAreaFreeshippings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collChronopostPrices = null;
        $this->collChronopostAreaFreeshippings = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ChronopostDeliveryTypeTableMap::DEFAULT_STRING_FORMAT);
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

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
