<?php namespace sirajcse\UniqueIdGenerator\Traits;

use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

trait UniqueIdFactory
{
    private static function validateIdConfig()
    {
        if (!isset(self::$idConfig)) throw new \Exception("UniqueIdGenerator trait required ID config");

        if (!isset(self::$idConfig['length']) ) {
            throw new \Exception("length required for unique id/code generation");
        }
    }

    public static function bootUniqueIdGeneratable()
    {
        self::creating(function ($model) {
            self::validateIdConfig();
            $config = [
                'table'  => $model->getTable(),
                'length' => self::$idConfig['length'],
            ];

            if (isset(self::$idConfig['prefix'])) {
                $config['prefix'] = self::$idConfig['prefix'];
            }
            if (isset(self::$idConfig['suffix'])) {
                $config['suffix'] = self::$idConfig['suffix'];
            }
            if (isset(self::$idConfig['reset_on_change'])) {
                $config['reset_on_change'] = self::$idConfig['reset_on_change'];
            }
            if (isset(self::$idConfig['field'])) {
                $config['field'] = self::$idConfig['field'];
                $model[self::$idConfig['field']] = UniqueIdGenerator::generate($config);
            } else {
                $model->id = UniqueIdGenerator::generate($config);
            }
        });
    }
}
