<?php

namespace app\generators\model;

use mootensai\enhancedgii\model\Generator;
use Yii;
use yii\base\NotSupportedException;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

/**
 *
 * @property-read string $tablePrefix
 */
class MyModelGenerator extends Generator
{


    public $db = 'db';
    public $nsModel = 'app\models';
    public string $baseModelNamespace = 'app\models\base';
    public string $commonModelNamespace = 'app\common\models';
    public $queryNs = 'app\models\query';
//    public $baseModelClass = 'BaseModel';
    public bool $standardizeCapitals = false;
    public bool $useSchemaName = true;
    public bool $singularize = false;
    public string $skipTables = 'migration';

    public $generateLabelsFromComments = true;
    public $generateQuery = false;
    public $useTablePrefix = true;
    public $optimisticLock = null;
    public $generateBaseOnly = false;


    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['baseModelNamespace'], 'required'];
        $rules[] = [['baseModelClass'], 'match',
            'pattern' => '/^(\w+\.)?([\w\*]+)$/',
            'message' => 'Only word characters are allowed.'];

        $rules[] = [['singularize', 'useSchemaName', 'standardizeCapitals', 'skipTables'], 'safe'];
        return $rules;
    }

    public function stickyAttributes()
    {
        $sticky = parent::stickyAttributes();
        $sticky[] = 'singularize';
        $sticky[] = 'skipTables';
        $sticky[] = 'standardizeCapitals';
        return $sticky;
    }

    public function getName()
    {
        return "Masgeek Generator (Model)";
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['standardizeCapitals'] = 'Standardize Capitals';
        $labels['singularize'] = 'Singularize';
        return $labels;
    }

    public function hints()
    {
        $hints = parent::hints();
        $hints['skipTables'] = 'Enter the names of the tables to skip, separated by commas.
                The table name may end with asterisk to match multiple table names, e.g. <code>tbl_*</code>
                will match tables whose name starts with <code>tbl_</code>.';
        return $hints;
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        $this->nameAttribute = ($this->nameAttribute) ? explode(',', str_replace(' ', '', $this->nameAttribute)) : [];
        $this->skippedColumns = ($this->skippedColumns) ? explode(',', str_replace(' ', '', $this->skippedColumns)) : [];
        $this->skippedRelations = ($this->skippedRelations) ? explode(',', str_replace(' ', '', $this->skippedRelations)) : [$this->skippedRelations];
        $skippedTables = ($this->skipTables) ? explode(',', str_replace(' ', '', $this->skipTables)) : [$this->skipTables];
        $this->skippedColumns = array_filter($this->skippedColumns);
        $this->skippedRelations = array_filter($this->skippedRelations);


        $tableNames = $this->getTableNames();
        // Filter out the tables that are in the skipped tables list
        $filteredTableNames = array_filter($tableNames, function ($tableName) use ($skippedTables) {
            foreach ($skippedTables as $pattern) {
                // If the table name matches any pattern with wildcard
                if (fnmatch($pattern, $tableName)) {
                    return false;
                }
            }
            return true;
        });

        foreach ($filteredTableNames as $tableName) {
            // model:
            if (strpos($this->tableName, '*') !== false) {
                $modelClassName = $this->generateClassName($tableName);
            } else {
                $modelClassName = (!empty($this->modelClass)) ? $this->modelClass : Inflector::id2camel($tableName, '_');
                if ($this->singularize) {
                    $modelClassName = Inflector::singularize($modelClassName);
                }
            }

            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableRelations = isset($relations[$tableName]) ? $relations[$tableName] : [];
            $tableSchema = $db->getTableSchema($tableName);
            $this->modelClass = "{$this->nsModel}\\{$modelClassName}";
            $this->tableSchema = $tableSchema;
            $this->isTree = !array_diff(self::getTreeColumns(), $tableSchema->columnNames);

            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'properties' => $this->generateProperties($tableSchema),
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => $tableRelations,
                'isTree' => $this->isTree
            ];


            //Base Model
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->baseModelNamespace)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );

            //Extended model
            if (!$this->generateBaseOnly) {
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->nsModel)) . '/' . $modelClassName . '.php', $this->render('model-extended.php', $params)
                );
            }

            // query :
            if ($queryClassName) {
                $params = [
                    'className' => $queryClassName,
                    'modelClassName' => $modelClassName,
                ];
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php', $this->render('query.php', $params)
                );
            }

            if (strpos($this->tableName, '*') !== false) {
                $this->modelClass = '';
            } else {
                $this->modelClass = $modelClassName;
            }
        }
        $this->nameAttribute = (is_array($this->nameAttribute)) ? implode(', ', $this->nameAttribute) : '';
        $this->skippedColumns = (is_array($this->skippedColumns)) ? implode(', ', $this->skippedColumns) : '';
        $this->skippedRelations = (is_array($this->skippedRelations)) ? implode(', ', $this->skippedRelations) : '';

        return $files;
    }

    /**
     * @return array the table names that match the pattern specified by [[tableName]].
     */
    protected function getTableNames()
    {
        if ($this->tableNames !== null) {
            return $this->tableNames;
        }
        $db = $this->getDbConnection();
        if ($db === null) {
            return [];
        }
        $tableNames = [];
        if (str_contains($this->tableName, '*')) {
            if (($pos = strrpos($this->tableName, '.')) !== false) {
                $schema = substr($this->tableName, 0, $pos);
                $pattern = '/^' . str_replace('*', '\w+', substr($this->tableName, $pos + 1)) . '$/';
            } else {
                $schema = '';
                $pattern = '/^' . str_replace('*', '\w+', $this->tableName) . '$/';
            }

            foreach ($db->schema->getTableNames($schema) as $table) {
                if (preg_match($pattern, $table)) {
                    $tableNames[] = $schema === '' ? $table : ($schema . '.' . $table);
                }
            }

        } elseif (($table = $db->getTableSchema($this->tableName, true)) !== null) {
            if (!in_array($this->tableName, $skipped_tables, true)) {
                $tableNames[] = $this->tableName;
                $this->classNames[$this->tableName] = $this->modelClass;
            }
        }

        return $this->tableNames = $tableNames;
    }


    /**
     * Generates a class name from the specified table name.
     * @param string $tableName the table name (which may contain schema prefix)
     * @param bool $useSchemaName should schema name be included in the class name, if present
     * @return string the generated class name
     */
    protected function generateClassName($tableName, $useSchemaName = null)
    {

        if (isset($this->classNames[$tableName])) {
            return $this->classNames[$tableName];
        }
        $schemaName = '';

        $fullTableName = $tableName;

        if (($pos = strrpos($tableName, '.')) !== false) {
            if (($useSchemaName === null && $this->useSchemaName) || $useSchemaName) {
                $schemaName = substr($tableName, 0, $pos) . '_';
            }
            $tableName = substr($tableName, $pos + 1);
        }


        $db = $this->getDbConnection();
        $patterns = [];
        $patterns[] = "/^{$db->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$db->tablePrefix}$/";
        if (str_contains($this->tableName, '*')) {
            $pattern = $this->tableName;
            if (($pos = strrpos($pattern, '.')) !== false) {
                $pattern = substr($pattern, $pos + 1);
            }
            $patterns[] = '/^' . str_replace('*', '(\w+)', $pattern) . '$/';
        }

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $tableName, $matches)) {
                $className = $matches[1];
                break;
            }
        }


        if ($this->standardizeCapitals) {
            $schemaName = ctype_upper(preg_replace('/[_-]/', '', $schemaName)) ? strtolower($schemaName) : $schemaName;
            $className = ctype_upper(preg_replace('/[_-]/', '', $className)) ? strtolower($className) : $className;
            $this->classNames[$fullTableName] = Inflector::camelize(Inflector::camel2words($schemaName . $className));
        } else {
            $this->classNames[$fullTableName] = Inflector::id2camel($schemaName . $className, '_');
        }

        if ($this->singularize) {
            $this->classNames[$fullTableName] = Inflector::singularize($this->classNames[$fullTableName]);
        }

        return $this->classNames[$fullTableName];
    }

    /**
     * Returns the `tablePrefix` property of the DB connection as specified
     *
     * @return string
     * @since 2.0.5
     * @see getDbConnection
     */
    public function getTablePrefix(): string
    {
        $db = $this->getDbConnection();
        if ($db !== null) {
            return $db->tablePrefix;
        }

        return '';
    }

    /**
     * Generates validation rules for the specified table.
     * @param \yii\db\TableSchema $table the table schema
     * @return array the generated validation rules
     */
    public function generateRules($table)
    {
        $types = [];
        $lengths = [];
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!$column->allowNull && $column->defaultValue === null && (!$this->isTree || !in_array($column->name, ['lft', 'rgt', 'lvl']))) {
                $types['required'][] = $column->name;
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_TINYINT:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $types['safe'][] = $column->name;
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }
        $rules = [];
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }

        // Unique indexes rules
        try {
            $db = $this->getDbConnection();
            $uniqueIndexes = $db->getSchema()->findUniqueIndexes($table);
            foreach ($uniqueIndexes as $uniqueColumns) {
                // Avoid validating auto incremental columns
                if (!$this->isColumnAutoIncremental($table, $uniqueColumns)) {
                    $attributesCount = count($uniqueColumns);

                    if ($attributesCount == 1) {
                        $rules[] = "[['" . $uniqueColumns[0] . "'], 'unique']";
                    } elseif ($attributesCount > 1) {
                        $labels = array_intersect_key($this->generateLabels($table), array_flip($uniqueColumns));
                        $lastLabel = array_pop($labels);
                        $columnsList = implode("', '", $uniqueColumns);
                        $rules[] = "[['" . $columnsList . "'], 'unique', 'targetAttribute' => ['" . $columnsList . "'], 'message' => 'The combination of " . implode(', ', $labels) . " and " . $lastLabel . " has already been taken.']";
                    }
                }
            }
            if (!empty($this->optimisticLock)) {
                $rules[] = "[['" . $this->optimisticLock . "'], 'default', 'value' => '0']";
                $rules[] = "[['" . $this->optimisticLock . "'], 'mootensai\\components\\OptimisticLockValidator']";
            }
        } catch (NotSupportedException $e) {
            // doesn't support unique indexes information...do nothing
        }

        return $rules;
    }

    /**
     * Generates the properties for the specified table.
     * @param yii\db\TableSchema $table the table schema
     * @return array the generated properties (property => type)
     * @since 2.0.6
     */
    public function generateProperties(TableSchema $table): array
    {
        $properties = [];
        foreach ($table->columns as $column) {
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $type = 'integer';
                    break;
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_TINYINT:
                    $type = 'boolean';
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $type = 'float';
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                case Schema::TYPE_JSON:
                    $type = 'string';
                    break;
                default:
                    $type = $column->phpType;
            }
            if ($column->allowNull) {
                $type .= '|null';
            }
            $properties[$column->name] = [
                'type' => $type,
                'name' => $column->name,
                'comment' => $column->comment,
            ];
        }

        return $properties;
    }

    protected function generateRelations()
    {
        // Store the original value of nsModel
        $originalNsModel = $this->nsModel;
        $this->nsModel = $this->baseModelNamespace;
        $relations = parent::generateRelations();
        if (!$this->generateRelations === self::RELATIONS_NONE) {
            return [];
        }

        $this->nsModel = $originalNsModel;
        return $relations;
    }

}
