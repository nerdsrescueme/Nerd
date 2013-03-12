<?php

namespace CMS;

use Doctrine\ORM\EntityManager;
use CMS\Entity\Session;

/**
 * @document
 */
class CmsSessionHandler implements \SessionHandlerInterface
{
    private $em;
    private $record;

	public function __construct(EntityManager $em)
	{
        $this->em = $em;
	}

	/**
     * {@inheritdoc}
     */
    public function open($path = null, $name = null)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        $this->em->remove($this->record);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($lifetime)
    {
        $this->em->getRepository('CMS\Entity\Session')->deleteOldRecords();

        return true;
    }

    public function read($id)
    {
        $this->record = $this->em->getRepository('CMS\Entity\Session')->find($id);

        if (!$this->record) {
            $this->record = $this->createNewSession($id);
        }

        return base64_decode($this->record->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function write($id, $data)
    {
        $this->record->setData(base64_encode($data));
        $this->em->persist($this->record);

        return true;
    }

    /**
     * @document
     */
    private function createNewSession($id, $data = '')
    {
        $record = new Session;
        $record->setId($id);
        $record->setData(base64_encode($data));

        return $record;
    }
}