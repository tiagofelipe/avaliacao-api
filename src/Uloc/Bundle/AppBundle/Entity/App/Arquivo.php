<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\App;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Classe abstrata para fornecer os métodos e requisitos para armazenar um arquivo no sistema
 *
 * @author Tiago Felipe
 * @version 0.0.1
 *
 * @ORM\MappedSuperclass()
 */
abstract class Arquivo
{

    /**
     * @ORM\Column(name="arquivo", type="string", nullable=true)
     *
     * @Assert\NotBlank(message="Por favor, faça o upload de um arquivo.")
     * @Assert\File(maxSize="8M")
     */
    protected $arquivo;

    /**
     * @ORM\Column(name="arquivo_tamanho", type="string", nullable=true)
     *
     */
    private $arquivoTamanho;

    function __construct()
    {
    }

    function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    public function fileInfo($options){
        return pathinfo($this->arquivo, $options);
    }

    public function fileName(){
        return $this->fileInfo(PATHINFO_FILENAME);
    }

    public function fileExtension(){
        return $this->fileInfo(PATHINFO_EXTENSION);
    }

    /**
     * @return mixed
     */
    public function getArquivoTamanho()
    {
        return $this->arquivoTamanho;
    }

    /**
     * @param mixed $arquivoTamanho
     */
    public function setArquivoTamanho($arquivoTamanho)
    {
        $this->arquivoTamanho = $arquivoTamanho;
    }

}
