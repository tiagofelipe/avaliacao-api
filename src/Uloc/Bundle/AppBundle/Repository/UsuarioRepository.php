<?php

namespace Uloc\Bundle\AppBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Uloc\Bundle\AppBundle\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class UsuarioRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param $username
     * @return Usuario
     */
    public function findUserByUsername($username)
    {
        return $this->findOneBy(array(
            'username' => $username
        ));
    }

    /**
     * @param $email
     * @return Usuario
     */
    public function findUserByEmail($email)
    {
        return $this->findOneBy(array(
            'email' => $email
        ));
    }

    /**
     * @return Usuario
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAny()
    {
        return $this->createQueryBuilder('u')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByUsername($username, $exception=true)
    {
        $user = $this->findUserByUsername($username);

        // allow login by email too
        if (!$user) {
            $user = $this->findUserByEmail($username);
        }

        if (!$user && $exception) {
            throw new UsernameNotFoundException(sprintf('Usuário "%s" não existe.', $username));
        }

        return $user;
    }

    /**
     * @param $login
     * @return null|object|Usuario
     */
    public function findUserByLogin($login){

        $usuario = $this->findOneBy(array('username' => $login));

        if (!$usuario) {
            $usuario = $this->findOneBy(array('email' => $login));
        }

        return $usuario;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserPasswordById($id){
        $dql = 'SELECT u.password FROM UlocAppBundle:Usuario u where u.id=:id';
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id)->setMaxResults(1);

        return $query->getResult();
    }

    public function findUsersChat($userLogged)
    {

        $query = $this->getEntityManager()->createQuery(
            'SELECT 
                      u.id, u.username, u.image, u.ultimoAcesso, p.nome,  
                      (SELECT count(1) FROM UlocAppBundle:Chat\ChatMensagem cm WHERE cm.usuario = u.id and cm.destinatario = :userLogged and cm.lido IS NULL) naoLidas  
                      FROM UlocAppBundle:Usuario u 
                      LEFT JOIN u.pessoa p 
                      WHERE u.roles LIKE :role 
                      ORDER BY naoLidas DESC, u.ultimoAcesso DESC'
        )
            ->setParameter('userLogged', $userLogged)
            ->setParameter('role', '%"ROLE_INTRANET"%'); //Somente usuários da intranet podem utilizar o chat

        return $query->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_ARRAY)->getResult();

    }

    public function findAllSimple($limit = 100, $offset = 0, $filtros = null)
    {

        $query = $this->getEntityManager()->createQueryBuilder()
            //->select('partial l.{id}, c.nome')
            ->select('u, p')
            ->from("UlocAppBundle:Usuario", "u")
            ->leftJoin('u.pessoa', 'p')
            ->where('u.roles LIKE :role and u.roles NOT LIKE :roleComitente')
            ->setParameter('role', '%"ROLE_INTRANET"%')
            ->setParameter('roleComitente', '%"ROLE_COMITENTE"%');

        $queryCount = $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(1) total')
            ->from("UlocAppBundle:Usuario", "u")
            ->leftJoin('u.pessoa', 'p')
            ->where('u.roles LIKE :role and u.roles NOT LIKE :roleComitente')
            ->setParameter('role', '%"ROLE_INTRANET"%')
            ->setParameter('roleComitente', '%"ROLE_COMITENTE"%');

        //Busca
        if (isset($filtros['busca'])) {
            $busca = $filtros['busca'];
            $filtroBuscaCriteria = Criteria::create()
                ->where(Criteria::expr()->orX(
                    Criteria::expr()->eq('u.id', $busca),
                    Criteria::expr()->contains('p.pfCpf', $busca),
                    Criteria::expr()->contains('p.pjCnpj', $busca),
                    Criteria::expr()->contains("p.nome", $busca),
                    Criteria::expr()->contains("p.pjRazaoSocial", $busca)
                ));
            $query->addCriteria($filtroBuscaCriteria);
            $queryCount->addCriteria($filtroBuscaCriteria);
        }

        //Tipo
        if (isset($filtros['tipo'])) {
            $tipo = $filtros['tipo'];
            $filtroTipoCriteria = Criteria::create()
                ->where(Criteria::expr()->eq('p.tipo', $tipo));
            $query->addCriteria($filtroTipoCriteria);
            $queryCount->addCriteria($filtroTipoCriteria);
        }

        //Status
        /*if (isset($filtros['status'])) {
            $status = $filtros['status'];
            $filtroStatusCriteria = Criteria::create()
                ->where(Criteria::expr()->in('a.status', $status));
            $query->addCriteria($filtroStatusCriteria);
            $queryCount->addCriteria($filtroStatusCriteria);
        }*/

        $query = $query->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->setHydrationMode(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //->getArrayResult();
        //return $paginator = new Paginator($query, $fetchJoinCollection = true); //https://github.com/doctrine/doctrine2/issues/2596
        return [
            'result' => $query->getArrayResult(), //getArrayResult
            'total' => $queryCount->getQuery()->getSingleScalarResult()
        ];
    }
}
