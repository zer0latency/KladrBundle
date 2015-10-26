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
            ->andWhere("o.code LIKE '%00'")
            ->andWhere("o.code in ('2300000000000', '6100000000000', '3400000000000', '3000000000000')")
            ->andWhere("o.socr in ('Респ','- Чувашия','край','обл','Аобл','АО')")
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
            ->andWhere("o.code LIKE '%00'")
            ->andWhere("o.socr not in ('Респ','- Чувашия','край','обл','Аобл','АО','р-н')")
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
            ->andWhere("o.code LIKE '%00'")
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
     * @Route("/kladr/path/")
     */
    public function pathAction()
    {
        $path   = $this->getRequest()->get('address');
        if ( !preg_match("/^.+,.*,.*,[0-9]+/", $path) ) {
            return new JsonResponse(array( "error" => "Bad Request." ), 400);
        }

        $em     = $this->getDoctrine()->getManager();

        $opts = explode(',', $path);
        $result['house'] = strstr($opts[0], ' ') ? explode(' ', $opts[0])[1] : $opts[0];
        $result['corps'] = strstr($opts[1], ' ') ? explode(' ', $opts[1])[1] : $opts[1];
        $result['flat']  = strstr($opts[2], ' ') ? explode(' ', $opts[2])[1] : $opts[2];
        $streetCode      = $opts[3];

        $street = $em->getRepository("KladrBundle:Street")->findOneByCode($streetCode);
        $city   = $em->getRepository("KladrBundle:Kladr")->findOneByCode((string)substr($streetCode, 0, -5).'0');
        $region = $em->getRepository("KladrBundle:Kladr")->findOneByCode((string)substr($streetCode, 0, 2).str_repeat('0', 11));

        if ( !$street OR !$city OR !$region) {
            return new JsonResponse(array("citycode" => (string)substr($streetCode, 0, -5) + '0'));
        }
        $result['city'] = $this->buildCityPath($city);
        $result['street'] = sprintf("%s %s", $street->getName(), $street->getSocr());
        $result['region'] = sprintf("%s %s", $region->getName(), $region->getSocr());

        return new JsonResponse($result);
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
