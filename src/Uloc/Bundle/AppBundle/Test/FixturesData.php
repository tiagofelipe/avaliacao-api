<?php

namespace Uloc\Bundle\AppBundle\Test;

/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

use \Doctrine\ORM\EntityManager;
use Uloc\Bundle\AppBundle\Entity\CategoriaLeilao;
use Uloc\Bundle\AppBundle\Entity\LeilaoLocal;
use Uloc\Bundle\AppBundle\Entity\Leiloeiro;
use Uloc\Bundle\AppBundle\Entity\Pessoa\CampoExtra;
use Uloc\Bundle\AppBundle\Entity\Pessoa\OrigemCadastro;
use Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa;
use Uloc\Bundle\AppBundle\Entity\Pessoa\TipoFinalidadeEmail;
use Uloc\Bundle\AppBundle\Entity\Pessoa\TipoFinalidadeEndereco;
use Uloc\Bundle\AppBundle\Entity\Pessoa\TipoFinalidadeTelefone;
use Uloc\Bundle\AppBundle\Entity\TipoComitente;

/**
 * Wrapper para ajudar nos testes preenchendo dados necessários para serem utilizados nos demais casos de uso
 */
class FixturesData
{
    private $em;
    public static $defaultIds;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function purge(){
        self::$defaultIds = array();
    }

    /**
     * Módulo Endereco
     */

    public function createPais($nome, $sigla)
    {
        $o = new \Uloc\Bundle\AppBundle\Entity\App\Pais();
        $o->setNome($nome);
        $o->setNomeGlobal($nome);
        $o->setSigla($sigla);
        $this->persist($o);
        self::addDefaultIds('pais', $o->getId());
        return $o;
    }

    public function createUf($nome, $sigla, $pais = null)
    {
        $o = new \Uloc\Bundle\AppBundle\Entity\App\UnidadeFederativa();
        $o->setNome($nome);
        $o->setSigla($sigla);
        $o->setPais($this->em->getReference("UlocAppBundle:App\Pais", $pais ?: self::$defaultIds['pais'][0]));
        $this->persist($o);
        self::addDefaultIds('uf', $o->getId());
        return $o;
    }

    public function createMunicipio($nome, $uf = null)
    {
        $o = new \Uloc\Bundle\AppBundle\Entity\App\Municipio();
        $o->setNome($nome);
        $o->setUf($this->em->getReference("UlocAppBundle:App\UnidadeFederativa", $uf ?: self::$defaultIds['uf'][0]));
        $this->persist($o);
        self::addDefaultIds('municipio', $o->getId());
        return $o;
    }

    public function createBairro($nome, $municipio = null)
    {
        $o = new \Uloc\Bundle\AppBundle\Entity\App\Bairro();
        $o->setNome($nome);
        $o->setMunicipio($this->em->getReference("UlocAppBundle:App\Municipio", $municipio ?: self::$defaultIds['municipio'][0]));
        $this->persist($o);
        self::addDefaultIds('bairro', $o->getId());
        return $o;
    }

    public function createTipoFinalidadeEndereco($nome)
    {
        $o = new TipoFinalidadeEndereco();
        $o->setNome($nome);
        $o->setCodigo(strval(rand(0000, 9999)));
        $this->persist($o);
        self::addDefaultIds('tipoFinalidadeEndereco', $o->getId());
        return $o;
    }

    /**
     * Módulo Contato
     */

    public function createTipoFinalidadeEmail($nome)
    {
        $o = new TipoFinalidadeEmail();
        $o->setNome($nome);
        $o->setCodigo(strval(rand(0000, 9999)));
        $this->persist($o);
        self::addDefaultIds('tipoFinalidadeEmail', $o->getId());
        return $o;
    }

    public function createTipoFinalidadeTelefone($nome)
    {
        $o = new TipoFinalidadeTelefone();
        $o->setCodigo(strval(rand(0000, 9999)));
        $o->setNome($nome);
        $this->persist($o);
        self::addDefaultIds('tipoFinalidadeTelefone', $o->getId());
        return $o;
    }

    /**
     * Módulo Pessoa
     */
    public function createCampoExtraPessoa($codigo, $nome, $descricao = 'Campo Extra Exemplo', $obrigatorio = false)
    {
        $o = new CampoExtra();
        $o->setCodigo($codigo);
        $o->setNome($nome);
        $o->setDescricao($descricao);
        $o->setObrigatorio($obrigatorio);
        $this->persist($o);
        self::addDefaultIds('pessoaCampoExtra', $o->getId());
        return $o;
    }

    public function createOrigemCadastroPessoa($nome)
    {
        $o = new OrigemCadastro();
        $o->setCodigo(strval(rand(0000, 9999)));
        $o->setNome($nome);
        $this->persist($o);
        self::addDefaultIds('origemCadastroPesoa', $o->getId());
        return $o;
    }

    public function createCategoriaLeilao($nome)
    {
        $o = new CategoriaLeilao();
        $o->setNome($nome);
        $o->setCodigo(rand());
        $this->persist($o);
        self::addDefaultIds('categoriaLeilao', $o->getId());
        return $o;
    }

    public function createLeiloeiro($pessoaId = false)
    {
        $pessoa = new Pessoa();
        $pessoa->setNome('Rogério Menezes');
        $pessoa->setTipo(Pessoa::PESSOA_FISICA);
        $this->persist($pessoa);

        $o = new Leiloeiro();
        $o->setPessoa($this->em->getReference("UlocAppBundle:Pessoa\Pessoa", $pessoa->getId()));
        $this->persist($o);
        self::addDefaultIds('leiloeiro', $o->getId());
        return $o;
    }

    public function createTipoComitente($nome){
        $o = new TipoComitente();
        $o->setCodigo(rand());
        $o->setNome($nome);
        $o->setIsHabilitado(true);
        $this->persist($o);
        self::addDefaultIds('tipoComitente', $o->getId());
    }

    public function createLeilaoLocal($nome)
    {
        $o = new LeilaoLocal();
        $o->setNome($nome);
        $o->setCodigo(rand());
        $this->persist($o);
        self::addDefaultIds('leilaoLocal', $o->getId());
        return $o;
    }

    public static function addDefaultIds($name, $val)
    {
        if (isset(self::$defaultIds[$name])) {
            if (is_array(self::$defaultIds[$name])) {
                array_push(self::$defaultIds[$name], $val);
            } else {
                self::$defaultIds[$name] = array($val);
            }
        } else {
            self::$defaultIds[$name] = array($val);
        }
    }

    private function persist($o)
    {
        $this->em->persist($o);
        $this->em->flush();
        $this->em->getUnitOfWork()->clear(); //Limpa a unidade de trabalho do doctrine (for performance
        return $o;
    }

}