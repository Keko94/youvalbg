<?php

namespace Tyras\UserBundle\Generator;


use Doctrine\ODM\MongoDB\DocumentManager;

class Generator extends \Doctrine\ODM\MongoDB\Id\AbstractIdGenerator
{
    protected $collection = null;
    protected $key = null;

    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function generate(DocumentManager $dm, $document)
    {
        $className = get_class($document);
        $db = $dm->getDocumentDatabase($className);

        $coll = $this->collection ?: 'doctrine_increment_ids';
        $key = $this->key ?: $dm->getDocumentCollection($className)->getName();

        $query = array('_id' => $key, 'field' => '_id');
        $newObj = array('$inc' => array('seq' => 1));

        $command = array();
        $command['findandmodify'] = $coll;
        $command['query'] = $query;
        $command['update'] = $newObj;
        $command['upsert'] = true;
        $command['new'] = true;
        $result = $db->command($command);

        return $result['value']['seq'];
    }
}