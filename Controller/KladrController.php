<?php

namespace zer0latency\KladrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class KladrController extends Controller
{
    /**
     * @Route("/kladr/region/")
     * @Template()
     */
    public function regionAction()
    {
        $region = $this->getRequest()->get('region');
        $em = $this->getDoctrine()->getManager();
        $result = array();

        $entities = $em->getRepository("KladrBundle:Kladr")->createQueryBuilder('o')
            ->where('o.name LIKE :name')
            ->andWhere("o.socr in ('Респ','Чувашия','край','обл','Аобл','АО')")
            ->setParameter('name', "%$region%")
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity) {
            $result[$entity->getCode()] = sprintf("%s %s", $entity->getName(), $entity->getSocr());
        }

        $response = new JsonResponse();
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/kladr/city/")
     */
    public function cityAction()
    {
        $region = substr($this->getRequest()->get('region'), 0, 2);
        $city   = $this->getRequest()->get('city');
        $em = $this->getDoctrine()->getManager();
        $result = array();

        $entities = $em->getRepository("KladrBundle:Kladr")->createQueryBuilder('o')
            ->where("o.name LIKE :name")
            ->andWhere("o.code LIKE :code")
            ->andWhere("o.socr != 'р-н'")
            ->setParameter('name', "%$city%")
            ->setParameter('code', "$region%")
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity) {
            $result[$entity->getCode()] = $this->buildCityPath($entity);
        }

        $response = new JsonResponse();
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/kladr/street/")
     * @Template()
     */
    public function streetAction()
    {
        $city   = substr($this->getRequest()->get('city'), 0, -2);
        $name   = $this->getRequest()->get('street');
        $em     = $this->getDoctrine()->getManager();
        $result = array();

        $entities = $em->getRepository("KladrBundle:Street")->createQueryBuilder('o')
            ->where('o.name LIKE :name')
            ->andWhere("o.code LIKE :code")
            ->setParameter('name', "%$name%")
            ->setParameter('code', "$city%")
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity) {
            $result[$entity->getCode()] = sprintf("%s %s",
                $entity->getName(),
                $entity->getSocr()
            );
        }

        $response = new JsonResponse();
        $response->setData($result);
        return $response;
    }

    /**
     * Добавить район к названию нас. пункта
     * @param KladrBundle:Kladr $entity
     * @return type
     */
    protected function buildCityPath($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $code = substr($entity->getCode(), 0, 5);

        $parent = $em->getRepository("KladrBundle:Kladr")->createQueryBuilder('k')
            ->where('k.code LIKE :code')
            ->andWhere('k.socr = :socr')
            ->setParameter('code', "$code%")
            ->setParameter('socr', 'р-н')
            ->getQuery()
            ->getResult();

        if ( !count($parent) ) {
            return sprintf("%s %s",
                $entity->getName(),
                $entity->getSocr()
            );
        }

        return sprintf("%s %s, %s %s",
            $parent[0]->getName(),
            $parent[0]->getSocr(),
            $entity->getName(),
            $entity->getSocr()
        );
    }

}
