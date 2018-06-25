<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\CommonEntity;
use Uloc\Bundle\AppBundle\Entity\FormEntity;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Uloc\Bundle\AppBundle\Validator\Constraints as DocAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Pessoa
 *
 * TODO: Ao cadastrar ou atualizar uma pessoa, manter o PessoaEssencialCache
 *
 * @ORM\Table(name="pessoa")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\PessoaRepository")
 * @UniqueEntity("pfCpf", message="Este CPF já está sendo usado por outra pessoa em nosso sistema", groups={"PessoaFisica"})
 * @UniqueEntity("pjCnpj", message="Este CNPJ já está sendo usado por outra pessoa em nosso sistema", groups={"PessoaJuridica"})
 */
class Pessoa extends CommonEntity
{
    const PESSOA_FISICA = 1;
    const PESSOA_JURIDICA = 2;

    const ESTADO_CIVIL = [
        1 => 'Solteiro(a)',
        2 => 'Casado(a)',
        3 => 'Viúvo(a)',
        4 => 'Separado(a)',
        5 => 'Divorciado(a)',
        6 => 'Amancebado(a)'
    ];

    const TipoString = [
        self::PESSOA_FISICA => 'Física',
        self::PESSOA_JURIDICA => 'Jurídica',
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar um nome válido")
     * @ORM\Column(name="nome", type="string", length=100)
     */
    protected $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCadastro", type="datetime")
     */
    protected $dataCadastro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataAlteracao", type="datetime", nullable=true)
     */
    protected $dataAlteracao;

    /**
     * @var int
     *
     * @ORM\Column(name="classificacao", type="smallint", nullable=true)
     */
    protected $classificacao;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    protected $foto;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    protected $status;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="smallint")
     */
    protected $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255, nullable=true)
     */
    protected $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="pf_tratamento", type="string", length=10, nullable=true)
     */
    protected $pfTratamento;

    /**
     * @var int
     * @Assert\NotBlank(message="É necessário informar um gênero", groups={"PessoaFisica"})
     * @ORM\Column(name="pf_sexo", type="smallint", nullable=true)
     */
    protected $pfSexo;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank(message="É necessário informar a data de nascimento", groups={"PessoaFisica"})
     * @ORM\Column(name="pf_data_nascimento", type="date", nullable=true)
     */
    protected $pfDataNascimento;

    /**
     * @var int
     *
     * @Assert\NotBlank(message="É necessário informar o estado civil", groups={"PessoaFisica"})
     * @ORM\Column(name="pf_estado_civil", type="smallint", nullable=true)
     */
    protected $pfEstadoCivil;

    public function getPfEstadoCivilString()
    {
        if (!isset(self::ESTADO_CIVIL[$this->pfEstadoCivil])) {
            return 'nd';
        }
        return self::ESTADO_CIVIL[$this->pfEstadoCivil];
    }

    /**
     * @var string
     *
     * @ORM\Column(name="pf_filiacao_nome_pai", type="string", length=255, nullable=true)
     */
    protected $pfFiliacaoNomePai;

    /**
     * @var string
     *
     * @ORM\Column(name="pf_filiacao_nome_mae", type="string", length=255, nullable=true)
     */
    protected $pfFiliacaoNomeMae;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="É necessário informar o cpf", groups={"PessoaFisica"})
     * @DocAssert\Cpf(groups={"PessoaFisica"})
     * @ORM\Column(name="pf_cpf", type="string", length=11, nullable=true)
     */
    protected $pfCpf;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar o RG", groups={"PessoaFisica"})
     * @ORM\Column(name="pf_rg", type="string", length=50, nullable=true)
     */
    protected $pfRg;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar o órgão emissor do RG", groups={"PessoaFisica"})
     * @ORM\Column(name="pf_rg_orgao_emissor", type="string", length=50, nullable=true)
     */
    protected $pfRgOrgaoEmissor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pf_rg_data_expedicao", type="date", nullable=true)
     */
    protected $pfRgDataExpedicao;

    /**
     * @var string
     *
     * @ORM\Column(name="pj_responsavel", type="string", length=255, nullable=true)
     */
    protected $pjResponsavel;

    /**
     * @var string
     *
     * @ORM\Column(name="pj_razao_social", type="string", length=255, nullable=true)
     */
    protected $pjRazaoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="pj_nome_fantasia", type="string", length=255, nullable=true)
     */
    protected $pjNomeFantasia;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar o CNPJ", groups={"PessoaJuridica"})
     * @ORM\Column(name="pj_cnpj", type="string", length=14, nullable=true)
     */
    protected $pjCnpj;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar a inscrição estadual.", groups={"PessoaJuridica"})
     * @ORM\Column(name="pj_inscricaoEstadual", type="string", length=100, nullable=true)
     */
    protected $pjInscricaoEstadual;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_cadastro", type="string", length=255, nullable=true)
     */
    protected $ipCadastro;

    /**
     * @var int
     * @Assert\NotBlank(message="É necessário informar a nacionalidade", groups={"PessoaFisica"})
     * @ORM\Column(name="nacionalidade", type="smallint", nullable=true)
     */
    protected $nacionalidade;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", nullable=true)
     */
    protected $observacao;

    /**
     * Um Pessoa tem Muitos Proprietarios
     * @ORM\OneToMany(targetEntity="PessoaProprietario", mappedBy="pessoa")
     */
    protected $proprietarios;

    /**
     * Um Proprietario tem Muitos PessoasGerenciadas
     * @ORM\OneToMany(targetEntity="PessoaProprietario", mappedBy="proprietario")
     */
    protected $pessoasGerenciadas;

    /**
     * Muitos Pessoas tem Um OrigemCadastro.
     * @ORM\ManyToOne(targetEntity="OrigemCadastro", inversedBy="pessoas")
     * @ORM\JoinColumn(name="origem_cadastro_id", referencedColumnName="id", nullable=true)
     */
    protected $origemCadastro;

    /**
     * Um Pessoa tem Muitos Papeis
     * @ORM\OneToMany(targetEntity="Papel", mappedBy="pessoa", cascade={"persist"})
     */
    protected $papeis;

    /**
     * Um SuperPessoa tem Muitos SuperPapeis
     * @ORM\OneToMany(targetEntity="Papel", mappedBy="superPessoa", cascade={"persist"})
     */
    protected $superPapeis;

    /**
     * Um Pessoa tem Muitos Anotacoes
     * @ORM\OneToMany(targetEntity="Anotacao", mappedBy="pessoa")
     */
    protected $anotacoes;

    /**
     * Um Pessoa tem Muitos AnotacoesHistoricoAlteracoes
     * @ORM\OneToMany(targetEntity="AnotacaoHistorico", mappedBy="pessoa", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    protected $anotacoesHistoricoAlteracoes;

    /**
     * Um Pessoa tem Muitos CamposExtras
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="PessoaCampoExtra", mappedBy="pessoa", cascade={"persist"})
     */
    protected $camposExtras;

    /**
     * Um Pessoa tem Muitos Emails
     * @Assert\Valid
     * @Assert\Count(
     *      groups={"registration"},
     *      min = 1,
     *      max = 1,
     *      exactMessage = "É necessário informar um e-mail",
     *      minMessage = "You must specify at least one email",
     *      maxMessage = "You cannot specify more than {{ limit }} emails")
     * @ORM\OneToMany(targetEntity="ContatoEmail", mappedBy="pessoa", cascade={"all"})
     */
    protected $emails;

    /**
     * Um Pessoa tem Muitos Telefones
     * @Assert\Valid
     * @Assert\Count(
     *      groups={"PessoaFisica", "PessoaJuridica"},
     *      min = 1,
     *      exactMessage = "É necessário informar seu telefone",
     *      minMessage = "É necessário informar ao menos um telefone"
     *      )
     * @ORM\OneToMany(targetEntity="ContatoTelefone", mappedBy="pessoa", cascade={"persist"})
     */
    protected $telefones;

    /**
     * Um Pessoa tem Muitos ContatosExtras
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="ContatoExtra", mappedBy="pessoa", cascade={"persist"})
     */
    protected $contatosExtras;

    /**
     * Um Pessoa tem Muitos IdentificadoresRegistrados
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="IdentificadorRegistrado", mappedBy="pessoa", cascade={"persist"})
     */
    protected $identificadoresRegistrados;

    /**
     * Um Pessoa tem Muitos Enderecos
     * @Assert\Valid
     * @Assert\Count(
     *      groups={"Default"},
     *      min = 1,
     *      max = 1,
     *      exactMessage = "É necessário informar seu endereço")
     * @ORM\OneToMany(targetEntity="EnderecoFisico", mappedBy="pessoa", cascade={"persist"})
     */
    protected $enderecos;

    /**
     * Um Pessoa tem Muitos Tags
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="pessoas", cascade={"persist"})
     * @ORM\JoinTable(name="pessoa_tag_pessoa")
     */
    protected $tags;

    /**
     * Um Criador tem Muitos TagsCriadas
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="criador")
     */
    protected $tagsCriadas;

    /**
     * Um Pessoa tem Muitos Usuarios
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", mappedBy="pessoa")
     */
    protected $usuarios;

    /**
     * Um Pessoa tem Muitos HistoricoComunicacao
     * @ORM\OneToMany(targetEntity="HistoricoComunicacao", mappedBy="pessoa", fetch="EXTRA_LAZY")
     */
    protected $historicoComunicacao;

    /**
     * @ORM\OneToOne(targetEntity="PessoaEssencialCache", mappedBy="pessoa")
     */
    private $essencial;

    /**
     * TODO: TEMPORÁRIO
     * @var array
     *
     * @ORM\Column(name="representantes", type="array", nullable=true)
     */
    private $representantes;

    /**
     * @return mixed
     */
    public function getHistoricoComunicacao()
    {
        return $this->historicoComunicacao;
    }

    /**
     * @param HistoricoComunicacao $historicoComunicacao
     */
    public function addHistoricoComunicacao(HistoricoComunicacao $historicoComunicacao)
    {
        $this->historicoComunicacao[] = $historicoComunicacao;
    }

    public function __construct()
    {
        $this->proprietarios = new ArrayCollection();
        $this->pessoasGerenciadas = new ArrayCollection();
        $this->papeis = new ArrayCollection();
        $this->superPapeis = new ArrayCollection();
        $this->anotacoes = new ArrayCollection();
        $this->anotacoesHistoricoAlteracoes = new ArrayCollection();
        $this->camposExtras = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->telefones = new ArrayCollection();
        $this->contatosExtras = new ArrayCollection();
        $this->enderecos = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->tagsCriadas = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
        $this->historicoComunicacao = new ArrayCollection();

        $this->dataCadastro = new \DateTime();
        $this->ipCadastro = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1'; //TODO: Verificar
        $this->status = 1;
    }

    /**
     * @return mixed
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param Usuario $usuario
     */
    public function addUsuario(Usuario $usuario)
    {
        $this->usuarios[] = $usuario;
    }

    /**
     * @return mixed
     */
    public function getTagsCriadas()
    {
        return $this->tagsCriadas;
    }

    /**
     * @param Tag $tagCriada
     */
    public function addTagCriada(Tag $tagCriada)
    {
        $this->tagsCriadas[] = $tagCriada;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @return ArrayCollection
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * @param EnderecoFisico $endereco
     */
    public function addEndereco(EnderecoFisico $endereco)
    {
        $endereco->setPessoa($this);
        $this->enderecos[] = $endereco;
    }

    public function removeEndereco(EnderecoFisico $endereco)
    {
        $this->enderecos->removeElement($endereco);
    }

    /**
     * @return mixed
     */
    public function getIdentificadoresRegistrados()
    {
        return $this->identificadoresRegistrados;
    }

    /**
     * @param IdentificadorRegistrado $identificadorRegistrado
     */
    public function addIdentificadorRegistrado(IdentificadorRegistrado $identificadorRegistrado)
    {
        $this->identificadoresRegistrados[] = $identificadorRegistrado;
    }

    /**
     * @return mixed
     */
    public function getContatosExtras()
    {
        return $this->contatosExtras;
    }

    /**
     * @param ContatoExtra $contatoExtra
     */
    public function addContatosExtras(ContatoExtra $contatoExtra)
    {
        $this->contatosExtras[] = $contatoExtra;
    }

    /**
     * @return ArrayCollection
     */
    public function getTelefones()
    {
        return $this->telefones;
    }

    /**
     * @param ContatoTelefone $telefone
     */
    public function addTelefone(ContatoTelefone $telefone)
    {
        $telefone->setPessoa($this);
        $this->telefones[] = $telefone;
    }

    public function removeTelefone(ContatoTelefone $telefone)
    {
        $this->telefones->removeElement($telefone);
    }

    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param ContatoEmail $email
     */
    public function addEmail(ContatoEmail $email)
    {
        $email->setPessoa($this);
        $this->emails[] = $email;
    }

    public function removeEmail(ContatoEmail $email)
    {
        $this->emails->removeElement($email);
    }
    public function removeEmails(ContatoEmail $email)
    {
        $this->removeEmail($email);
    }

    /**
     * @return mixed
     */
    public function getAnotacoes()
    {
        return $this->anotacoes;
    }

    /**
     * @param Anotacao $anotacao
     */
    public function addAnotacoes(Anotacao $anotacao)
    {
        $this->anotacoes[] = $anotacao;
    }

    /**
     * @return ArrayCollection|PessoaCampoExtra
     */
    public function getCamposExtras()
    {
        return $this->camposExtras;
    }

    /**
     * @param PessoaCampoExtra $campoExtra
     */
    public function addCamposExtra(PessoaCampoExtra $campoExtra)
    {
        $campoExtra->setPessoa($this);
        $this->camposExtras[] = $campoExtra;
    }

    /**
     * @param PessoaCampoExtra $campoExtra
     */
    public function removeCamposExtra(PessoaCampoExtra $campoExtra)
    {
        $this->camposExtras->removeElement($campoExtra);
    }

    /**
     * @return mixed
     */
    public function getAnotacoesHistoricoAlteracoes()
    {
        return $this->anotacoesHistoricoAlteracoes;
    }

    /**
     * @param AnotacaoHistorico $anotacaoAlterada
     */
    public function addAnotacaoAlterada(AnotacaoHistorico $anotacaoAlterada)
    {
        $this->anotacoesHistoricoAlteracoes[] = $anotacaoAlterada;
    }

    /**
     * @return mixed
     */
    public function getSuperPapeis()
    {
        return $this->superPapeis;
    }

    /**
     * @param Papel $superPapel
     */
    public function addSuperPapel(Papel $superPapel)
    {
        $this->superPapeis[] = $superPapel;
    }

    /**
     * @return mixed
     */
    public function getPapeis()
    {
        return $this->papeis;
    }

    /**
     * @param Papel $papel
     */
    public function addPapel(Papel $papel)
    {
        $this->papeis[] = $papel;
    }

    /**
     * @return mixed
     */
    public function getOrigemCadastro()
    {
        return $this->origemCadastro;
    }

    /**
     * @param OrigemCadastro $origemCadastro
     */
    public function setOrigemCadastro(OrigemCadastro $origemCadastro)
    {
        $this->origemCadastro = $origemCadastro;
    }

    /**
     * @return mixed
     */
    public function getPessoasGerenciadas()
    {
        return $this->pessoasGerenciadas;
    }

    /**
     * @param PessoaProprietario $pessoaGerenciada
     */
    public function addPessoaGerenciada(PessoaProprietario $pessoaGerenciada)
    {
        $this->pessoasGerenciadas[] = $pessoaGerenciada;
    }

    /**
     * @return mixed
     */
    public function getProprietarios()
    {
        return $this->proprietarios;
    }

    /**
     * @param PessoaProprietario $proprietario
     */
    public function addProprietario(PessoaProprietario $proprietario)
    {
        $this->proprietarios[] = $proprietario;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Pessoa
     */
    public function setNome($nome)
    {
        $this->nome = ucwords(mb_strtolower(trim($nome), 'UTF-8'));

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    public function getPrimeiroNome()
    {
        $nome = explode(' ', $this->nome);
        return ucfirst(mb_strtolower(trim($nome[0]), 'UTF-8'));
    }

    /**
     * Set dataCadastro
     *
     * @param \DateTime $dataCadastro
     *
     * @return Pessoa
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return \DateTime
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set dataAlteracao
     *
     * @param \DateTime $dataAlteracao
     *
     * @return Pessoa
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;

        return $this;
    }

    /**
     * Get dataAlteracao
     *
     * @return \DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set classificacao
     *
     * @param integer $classificacao
     *
     * @return Pessoa
     */
    public function setClassificacao($classificacao)
    {
        $this->classificacao = $classificacao;

        return $this;
    }

    /**
     * Get classificacao
     *
     * @return int
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Pessoa
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Pessoa
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {

        $representation->setGroup('public')
            ->addProperties([
                "emails" => array("email", "finalidade"),
                "telefones" => array("ddd", "telefone", "celular", "principal", "tipoFinalidade as finalidade", "finalidadeOutros"),
                "Enderecos" => array("finalidade" => array("id", "nome"), "logradouro", "numero", "complemento", "bairro", "municipio" => array("id", "nome", "uf" => array("id", "nome", "sigla"))),
                "origemCadastro as origem" => array("id", "nome as origem"),
                "camposExtras as extras" => array("id", "campoExtra" => array("id", "nome", "descricao", "obrigatorio"), "valor")
            ])
            ->setGroup('private')
            ->addProperties([
                "id",
                "dataCadastro"
            ]);

    }

    /**
     * Remove proprietario
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $proprietario
     */
    public function removeProprietario(\Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $proprietario)
    {
        $this->proprietarios->removeElement($proprietario);
    }

    /**
     * Add pessoasGerenciada
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $pessoasGerenciada
     *
     * @return Pessoa
     */
    public function addPessoasGerenciada(\Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $pessoasGerenciada)
    {
        $this->pessoasGerenciadas[] = $pessoasGerenciada;

        return $this;
    }

    /**
     * Remove pessoasGerenciada
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $pessoasGerenciada
     */
    public function removePessoasGerenciada(\Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaProprietario $pessoasGerenciada)
    {
        $this->pessoasGerenciadas->removeElement($pessoasGerenciada);
    }

    /**
     * Add papei
     * TODO: Digitado errado, corrigir tudo
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei
     *
     * @return Pessoa
     */
    public function addPapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei)
    {
        $this->papeis[] = $papei;

        return $this;
    }

    /**
     * Remove papei
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei
     */
    public function removePapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei)
    {
        $this->papeis->removeElement($papei);
    }

    /**
     * Add superPapei
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $superPapei
     *
     * @return Pessoa
     */
    public function addSuperPapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $superPapei)
    {
        $this->superPapeis[] = $superPapei;

        return $this;
    }

    /**
     * Remove superPapei
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $superPapei
     */
    public function removeSuperPapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $superPapei)
    {
        $this->superPapeis->removeElement($superPapei);
    }

    /**
     * Add anotaco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Anotacao $anotaco
     *
     * @return Pessoa
     */
    public function addAnotaco(\Uloc\Bundle\AppBundle\Entity\Pessoa\Anotacao $anotaco)
    {
        $this->anotacoes[] = $anotaco;

        return $this;
    }

    /**
     * Remove anotaco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Anotacao $anotaco
     */
    public function removeAnotaco(\Uloc\Bundle\AppBundle\Entity\Pessoa\Anotacao $anotaco)
    {
        $this->anotacoes->removeElement($anotaco);
    }

    /**
     * Add anotacoesHistoricoAlteraco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $anotacoesHistoricoAlteraco
     *
     * @return Pessoa
     */
    public function addAnotacoesHistoricoAlteraco(\Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $anotacoesHistoricoAlteraco)
    {
        $this->anotacoesHistoricoAlteracoes[] = $anotacoesHistoricoAlteraco;

        return $this;
    }

    /**
     * Remove anotacoesHistoricoAlteraco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $anotacoesHistoricoAlteraco
     */
    public function removeAnotacoesHistoricoAlteraco(\Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $anotacoesHistoricoAlteraco)
    {
        $this->anotacoesHistoricoAlteracoes->removeElement($anotacoesHistoricoAlteraco);
    }

    /**
     * Add contatosExtra
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoExtra $contatosExtra
     *
     * @return Pessoa
     */
    public function addContatosExtra(\Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoExtra $contatosExtra)
    {
        $this->contatosExtras[] = $contatosExtra;

        return $this;
    }

    /**
     * Remove contatosExtra
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoExtra $contatosExtra
     */
    public function removeContatosExtra(\Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoExtra $contatosExtra)
    {
        $this->contatosExtras->removeElement($contatosExtra);
    }

    /**
     * Add identificadoresRegistrado
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadoresRegistrado
     *
     * @return Pessoa
     */
    public function addIdentificadoresRegistrado(\Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadoresRegistrado)
    {
        $this->identificadoresRegistrados[] = $identificadoresRegistrado;

        return $this;
    }

    /**
     * Remove identificadoresRegistrado
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadoresRegistrado
     */
    public function removeIdentificadoresRegistrado(\Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadoresRegistrado)
    {
        $this->identificadoresRegistrados->removeElement($identificadoresRegistrado);
    }

    /**
     * Remove tag
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tag
     */
    public function removeTag(\Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Add tagsCriada
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tagsCriada
     *
     * @return Pessoa
     */
    public function addTagsCriada(\Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tagsCriada)
    {
        $this->tagsCriadas[] = $tagsCriada;

        return $this;
    }

    /**
     * Remove tagsCriada
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tagsCriada
     */
    public function removeTagsCriada(\Uloc\Bundle\AppBundle\Entity\Pessoa\Tag $tagsCriada)
    {
        $this->tagsCriadas->removeElement($tagsCriada);
    }

    /**
     * Remove usuario
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Uloc\Bundle\AppBundle\Entity\Usuario $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Remove historicoComunicacao
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\HistoricoComunicacao $historicoComunicacao
     */
    public function removeHistoricoComunicacao(\Uloc\Bundle\AppBundle\Entity\Pessoa\HistoricoComunicacao $historicoComunicacao)
    {
        $this->historicoComunicacao->removeElement($historicoComunicacao);
    }

    /**
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function getTipoString(){
        if(isset(self::TipoString[$this->tipo])){
            return self::TipoString[$this->tipo];
        }
        return 'n/d';
    }

    /**
     * @param int $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return string
     */
    public function getPfTratamento()
    {
        return $this->pfTratamento;
    }

    /**
     * @param string $pfTratamento
     */
    public function setPfTratamento($pfTratamento)
    {
        $this->pfTratamento = $pfTratamento;
    }

    /**
     * @return int
     */
    public function getPfSexo()
    {
        return $this->pfSexo;
    }

    /**
     * @param int $pfSexo
     */
    public function setPfSexo(int $pfSexo)
    {
        $this->pfSexo = $pfSexo;
    }

    /**
     * @return \DateTime
     */
    public function getPfDataNascimento()
    {
        return $this->pfDataNascimento;
    }

    /**
     * @param \DateTime $pfDataNascimento
     */
    public function setPfDataNascimento($pfDataNascimento)
    {
        $this->pfDataNascimento = $pfDataNascimento;
    }

    /**
     * @return int
     */
    public function getPfEstadoCivil()
    {
        return $this->pfEstadoCivil;
    }

    /**
     * @param int $pfEstadoCivil
     */
    public function setPfEstadoCivil($pfEstadoCivil)
    {
        $this->pfEstadoCivil = $pfEstadoCivil;
    }

    /**
     * @return string
     */
    public function getPfFiliacaoNomePai()
    {
        return $this->pfFiliacaoNomePai;
    }

    /**
     * @param string $pfFiliacaoNomePai
     */
    public function setPfFiliacaoNomePai($pfFiliacaoNomePai)
    {
        $this->pfFiliacaoNomePai = $pfFiliacaoNomePai;
    }

    /**
     * @return string
     */
    public function getPfFiliacaoNomeMae()
    {
        return $this->pfFiliacaoNomeMae;
    }

    /**
     * @param string $pfFiliacaoNomeMae
     */
    public function setPfFiliacaoNomeMae($pfFiliacaoNomeMae)
    {
        $this->pfFiliacaoNomeMae = $pfFiliacaoNomeMae;
    }

    /**
     * @return string
     */
    public function getPfCpf()
    {
        return $this->pfCpf;
    }

    /**
     * @param string $cpf
     */
    public function setPfCpf($cpf)
    {
        $this->pfCpf = preg_replace('/\D/', '$1', $cpf);
    }

    /**
     * @return string
     */
    public function getPfRg()
    {
        return $this->pfRg;
    }

    /**
     * @param string $pfRg
     */
    public function setPfRg($pfRg)
    {
        $this->pfRg = $pfRg;
    }

    /**
     * @return string
     */
    public function getPfRgOrgaoEmissor()
    {
        return $this->pfRgOrgaoEmissor;
    }

    /**
     * @param string $pfRgOrgaoEmissor
     */
    public function setPfRgOrgaoEmissor($pfRgOrgaoEmissor)
    {
        $this->pfRgOrgaoEmissor = $pfRgOrgaoEmissor;
    }

    /**
     * @return \DateTime
     */
    public function getPfRgDataExpedicao()
    {
        return $this->pfRgDataExpedicao;
    }

    /**
     * @param \DateTime $pfRgDataExpedicao
     */
    public function setPfRgDataExpedicao($pfRgDataExpedicao)
    {
        $this->pfRgDataExpedicao = $pfRgDataExpedicao;
    }

    /**
     * @return string
     */
    public function getPjResponsavel()
    {
        return $this->pjResponsavel;
    }

    /**
     * @param string $pjResponsavel
     */
    public function setPjResponsavel($pjResponsavel)
    {
        $this->pjResponsavel = $pjResponsavel;
    }

    /**
     * @return string
     */
    public function getPjRazaoSocial()
    {
        return $this->pjRazaoSocial;
    }

    /**
     * @param string $pjRazaoSocial
     */
    public function setPjRazaoSocial($pjRazaoSocial)
    {
        $this->pjRazaoSocial = $pjRazaoSocial;
    }

    /**
     * @return string
     */
    public function getPjNomeFantasia()
    {
        return $this->pjNomeFantasia;
    }

    /**
     * @param string $pjNomeFantasia
     */
    public function setPjNomeFantasia($pjNomeFantasia)
    {
        $this->pjNomeFantasia = $pjNomeFantasia;
    }

    /**
     * @return string
     */
    public function getPjCnpj()
    {
        return $this->pjCnpj;
    }

    /**
     * @param string $cnpj
     */
    public function setPjCnpj($cnpj)
    {
        $this->pjCnpj = preg_replace('/\D/', '$1', $cnpj);
    }

    /**
     * @return string
     */
    public function getIpCadastro()
    {
        return $this->ipCadastro;
    }

    /**
     * @param string $ipCadastro
     */
    public function setIpCadastro($ipCadastro)
    {
        $this->ipCadastro = $ipCadastro;
    }

    /**
     * @return int
     */
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    /**
     * @param int $nacionalidade
     */
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;
    }

    /**
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }

    /**
     * @return string
     */
    public function getPjInscricaoEstadual()
    {
        return $this->pjInscricaoEstadual;
    }

    /**
     * @param string $pjInscricaoEstadual
     */
    public function setPjInscricaoEstadual($pjInscricaoEstadual)
    {
        $this->pjInscricaoEstadual = $pjInscricaoEstadual;
    }

    /**
     * @return PessoaEssencialCache
     */
    public function getEssencial()
    {
        return $this->essencial;
    }

    /**
     * @param mixed $essencial
     */
    public function setEssencial(PessoaEssencialCache $essencial)
    {
        $this->essencial = $essencial;
    }

    /**
     * @return array
     */
    public function getRepresentantes()
    {
        return $this->representantes;
    }

    /**
     * @param array $representantes
     */
    public function setRepresentantes($representantes)
    {
        $this->representantes = $representantes;
    }

}
