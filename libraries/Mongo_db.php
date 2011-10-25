<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

class Mongo_db extends Mongo
{

    private $ci;

    public function __construct()
    {
        $this->ci = get_instance();
        $this->ci->config->load('mongo');
        try
        {
            parent::__construct(config_item('mongo_host') . ':' . config_item('mongo_port'));
        }
        catch (MongoConnectionException $e)
        {
            show_error("MongoDB connection failed: {$e->getMessage()}", 500);
        }

        if (!config_item('mongo_database'))
        {
            show_error('mongo_database can not empty.', 500);
        }
    }

    public function __get($name)
    {
        if ($name == 'gridfs')
        {
            return $this->selectDB(config_item('mongo_database'))->getGridFS();
        }
        else
        {
            return $this->selectCollection(config_item('mongo_database'), $name);
        }
    }

    public function batchInsert($a, $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE));
            return parent::batchInsert($a, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB batchInsert failed: {$e->getMessage()}", 500);
        }
    }

    public function ensureIndex($keys, $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE));
            return parent::ensureIndex($keys, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB ensureIndex failed: {$e->getMessage()}", 500);
        }
    }

    public function insert($a, $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE));
            return parent::insert($a, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB insert failed: {$e->getMessage()}", 500);
        }
    }

    public function remove($criteria = array(), $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE));
            return parent::remove($criteria, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB remove failed: {$e->getMessage()}", 500);
        }
    }

    public function save($a, $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE));
            return parent::save($a, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB save failed: {$e->getMessage()}", 500);
        }
    }

    public function update($criteria, $newobj, array $options = array())
    {
        try
        {
            $options = array_merge($options, array('safe' => TRUE, 'multiple' => FALSE));
            return parent::update($criteria, $newobj, $options);
        }
        catch (MongoCursorException $e)
        {
            show_error("MongoDB update failed: {$e->getMessage()}", 500);
        }
    }

}