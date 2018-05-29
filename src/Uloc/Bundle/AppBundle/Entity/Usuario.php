<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Uloc\Bundle\AppBundle\Entity\Endereco\EnderecoFisico;
use Uloc\Bundle\AppBundle\Entity\Notificacao\Notificacao;
use Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * @UniqueEntity(
 *     fields={"email"},
 *     message="O email informado já está sendo utilizado por outra pessoa.")
 * * @UniqueEntity(
 *     fields={"username"},
 *     message="O usuário informado já está sendo utilizado por outra pessoa.")
 * @ORM\Table(name="app_usuario")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
{

    const USER_PANEL = 1;
    const USER_APP = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * TODO: Implementar Badwords
     * @Assert\NotBlank(message="Necessario informar um nome de usuario")
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Necessario informar um email para o novo usuario")
     * @Assert\Email(message="Necessario informar um email válido para o novo usuario", checkMX=true)
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles;

    /**
     * Um Usuario tem Muitas NotificacaoUsuario
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario", mappedBy="usuario")
     */
    private $notificacoes;

    /**
     * Muitos Usuarios tem Uma Pessoa.
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa", inversedBy="usuarios", cascade={"persist"})
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string")
     */
    private $nome;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_usuario", type="smallint")
     */
    private $tipoUsuario;

    /**
     * One Usuario existe One ACL.
     * @ORM\OneToOne(targetEntity="UsuarioACL", mappedBy="usuario")
     */
    private $acl;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="GrupoUsuario", inversedBy="usuarios")
     * @ORM\JoinTable(name="app_usuarios_grupos")
     */
    private $grupos;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ultimoAcesso;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @var Estabelecimento[]
     *
     * @ORM\ManyToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Estabelecimento", inversedBy="proprietarios")
     * @ORM\JoinTable(name="proprietario_estabelecimento")
     */
    private $estabelecimentos;

    /**
     * @var Avaliacao[]
     *
     * // TODO: VERIFICAR A NECESSIDADE O ORPHANREMOVAL
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Avaliacao", mappedBy="usuario", orphanRemoval=true)
     */
    private $avaliacoes;

    /**
     * @var EnderecoFisico[]
     *
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Endereco\EnderecoFisico", mappedBy="usuario")
     */
    private $enderecos;


    public function __construct()
    {
        $this->notificacoes = new ArrayCollection();
        $this->grupos = new ArrayCollection();
        $this->estabelecimentos = new ArrayCollection();
        $this->avaliacoes = new ArrayCollection();
        $this->enderecos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * @param mixed $acl
     */
    public function setAcl(UsuarioACL $acl)
    {
        $this->acl = $acl;
    }

    /**
     * @return Pessoa
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param Pessoa $pessoa
     */
    public function setPessoa(Pessoa $pessoa)
    {
        $pessoa->addUsuario($this);
        $this->pessoa = $pessoa;
    }

    /**
     * @return mixed
     */
    public function getNotificacoes()
    {
        return $this->notificacoes;
    }

    /**
     * @param Notificacao $notificacao
     */
    public function addNotificacao(Notificacao $notificacao)
    {
        $this->notificacoes[] = $notificacao;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return mixed
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * @param mixed $grupo
     */
    public function addGrupo(GrupoUsuario $grupo)
    {
        $this->grupos[] = $grupo;
    }

    /**
     * Add notificaco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $notificaco
     *
     * @return Usuario
     */
    public function addNotificaco(\Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $notificaco)
    {
        $this->notificacoes[] = $notificaco;

        return $this;
    }

    /**
     * Remove notificaco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $notificaco
     */
    public function removeNotificaco(\Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $notificaco)
    {
        $this->notificacoes->removeElement($notificaco);
    }

    /**
     * Remove grupo
     *
     * @param \Uloc\Bundle\AppBundle\Entity\GrupoUsuario $grupo
     */
    public function removeGrupo(\Uloc\Bundle\AppBundle\Entity\GrupoUsuario $grupo)
    {
        $this->grupos->removeElement($grupo);
    }

    /**
     * @return mixed
     */
    public function getUltimoAcesso()
    {
        return $this->ultimoAcesso;
    }

    /**
     * @param mixed $ultimoAcesso
     */
    public function setUltimoAcesso($ultimoAcesso)
    {
        $this->ultimoAcesso = $ultimoAcesso;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        if ($this->getPessoa()) {
            return $this->getPessoa()->getNome();
        }
        return $this->username;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return int
     */
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    /**
     * @param int $tipoUsuario
     */
    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    /**
     * @return ArrayCollection|Estabelecimento|Estabelecimento[]
     */
    public function getEstabelecimentos()
    {
        return $this->estabelecimentos;
    }

    /**
     * @param Estabelecimento $estabelecimento
     */
    public function addEstabelecimento(Estabelecimento $estabelecimento)
    {
        $this->estabelecimentos[] = $estabelecimento;
    }

    /**
     * @return Avaliacao[]
     */
    public function getAvaliacoes()
    {
        return $this->avaliacoes;
    }

    /**
     * @param Avaliacao $avaliacao
     */
    public function setAvaliacaos(Avaliacao $avaliacao)
    {
        $this->avaliacoes[] = $avaliacao;
    }


    /**
     * @return EnderecoFisico[]
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
        $this->enderecos[] = $endereco;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation
            ->setGroup('public')
            ->addProperties([
                'id',
                'username',
                'email',
                'roles',
                'image',
                'ultimoAcesso',
                'pessoa' => array(
                    'id',
                    'nome',
                    'tipo',
                    'pfCpf as cpf',
                    'pjCnpj as cnpj',
                    'pjNomeFantasia as nomeFantasia',
                    'pjInscricaoEstadual as inscricaoEstadual',
                    'telefones' => array('id', 'telefone'),
                    'enderecos' => array(
                        'id',
                        'logradouro',
                        'bairro',
                        'cep',
                        'municipio' => array(
                            'id',
                            'nome',
                            'uf' => array('id', 'nome', 'sigla')
                        ),
                    ),
                    'observacao'
                )
            ])
            ->setGroup('api_edit')
            ->addProperties(
                [
                    'id',
                    'username',
                    'email',
                    'roles',
                    'image',
                    'ultimoAcesso',
                    'pessoa' => [
                        'id',
                        'nome',
                        'tipo',
                        'pfCpf cpf',
                        'pfCpf',
                        'pfRg',
                        'pfRg',
                        'pjCnpj cnpj',
                        'pjCnpj',
                        'dataCadastro',
                        'dataAlteracao',
                        'classificacao',
                        'foto',
                        'status',
                        'pfTratamento',
                        'pfSexo',
                        'pfDataNascimento',
                        'pfEstadoCivil',
                        'pfFiliacaoNomePai',
                        'pfFiliacaoNomeMae',
                        'pfRg',
                        'pfRgOrgaoEmissor',
                        'pfRgDataExpedicao',
                        'pjResponsavel',
                        'pjRazaoSocial',
                        'pjNomeFantasia',
                        'pjInscricaoEstadual',
                        'ipCadastro',
                        'nacionalidade',
                        'observacao',
                        "emails" => array("email", "finalidade"),
                        "telefones" => array("telefone", "celular", "principal", "tipoFinalidade as finalidade", "finalidadeOutros"),
                        "enderecos" => array(
                            "finalidade" => array("id", "nome"),
                            "cep",
                            "logradouro",
                            "numero",
                            "complemento",
                            "bairro",
                            "cidadeOutros",
                            "ufOutros",
                            "municipio" => array("id", "nome", "uf" => array("id", "nome", "sigla"))),
                        "origemCadastro as origem" => array("id", "nome as origem"),
                        "camposExtras as extras" => array("id", "campoExtra" => array("id", "nome", "descricao", "obrigatorio"), "valor")
                    ]
                ]
            );
        $representation->build();
    }
}
