<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Endereco\App;


/**
 * @author Tiago Felipe
 * @version 0.0.1
 */
abstract class Variavel
{

	private $nome;
	private $valor;

	/**
	 * parametros para chamar alguma funcao especifica para tratamento da variavel.
	 */
	private $callback;
	private $ativo;

	function __construct()
	{
	}

	function __destruct()
	{
	}



}
