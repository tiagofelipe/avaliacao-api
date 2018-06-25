<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Helpers;


use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

trait Utils
{

    /**
     * Em alguns casos, atrributos de objetos em respostas da API precisam ser modificadas de forma global.
     * Este método estático resolve este problema. Por exemplo, em muitas respostas da API precisamos enviar uma data,
     * que normalmente será uma intância \DateTime. Supomos que precisamos enviar na resposta da API o timestamp desta
     * data, porém seja necessário adicionar três zeros ao método getTimestamp. Basta adicionar uma escuta à este método
     * e uma função anônima com a modificação necessára.
     * @param $valor
     * @param $campo
     * @return mixed
     */
    static function transformObjResponse($valor, $campo)
    {
        $listener = array(
            "getTimestamp" => function ($v) {
                return intval($v . '000'); //timestamp com milisegundos
            }
        );
        if (isset($listener[$campo])) {
            $fcn = $listener[$campo];
            return $fcn($valor);
        } else {
            return $valor;
        }
    }

    /*
     * Recebe erros de um manipulador de formulários e retorna um array de erros
     * Get errors from a form handler and return an array of errors
     * @param FormInterface $form
     * @return array
     */
    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

    /**
     * Monta os critérios de pesquisa de um objeto.
     *
     * Método para montar critérios de uma requisição de lista de objetos. Deve ser passado via GET da esguinte maneira:
     *
     * orderBy[]=id&orderByValue[]=DESC&orderBy[]=nome&orderByValue[]=ASC&limit=10&offset=10
     *
     * @param object $request Uma instância do Symfony\Component\HttpFoundation\Request com os parâmetros dinâmicos via GET
     * @return array Array com os parâmetros para o findBy do Doctrine.
     *
     */
    protected function montaCriterios(Request $request)
    {
        //Monta a query findBy padrão conforme solicitado
        $criteria = array();
        //Monta a query orderBy padrão conforme solicitado
        $orderBysArr = array();
        if ($request->get('orderBy')) {
            $orderBys = $request->get('orderBy');
            $orderBysValues = $request->get('orderByValue');
            //Varre o array de valores "orderBy" recebidos do GET
            foreach ($orderBys as $orderByKey => $orderBy) {
                $orderBysArr[$orderBy] = $orderBysValues[$orderByKey];
            }
        } else {
            $orderBy = array();
        }
        //Define um limite
        if ($request->get('limit')) {
            $limit = $request->get('limit') > self::MAX_RESULT_LIMIT ?
                self::MAX_RESULT_LIMIT :
                $request->get('limit');
        } else {
            $limit = self::MAX_RESULT_LIMIT;
        }
        //Define o offset
        $offset = intval($request->get('offset'));

        return array(
            "criteria" => $criteria,
            "orderBy" => $orderBysArr,
            "limit" => $limit,
            "offset" => $offset
        );
    }

    /**
     * Retorna uma lista de objetos já com os critérios padrões montados.
     *
     * @param string $repository Nome do repositório
     * @param Request $request Uma instância do Symfony\Component\HttpFoundation\Request com os parâmetros dinâmicos via GET
     * @param EntityManager $em Uma instância do Doctrine\ORM\EntityManager
     *
     * @return array Array com um ou mais objetos.
     *
     */
    protected function getRepositoryCriterios($repository, Request $request, EntityManager $em)
    {
        $criterios = $this->montaCriterios($request);
        $listObject = $em->getRepository($repository)->findBy($criterios['criteria'], $criterios['orderBy'], $criterios['limit'], $criterios['offset']);
        return $listObject;
    }

    /**
     * Monta um array com as propriedades solicitadas.
     *
     * Exemplos:
     *
     * Uma simples montagem:
     * montaObjeto($listaDeObjetos, array('id', 'nome')
     *
     * Montagem com relacionamentos:
     *
     * montaObjeto($listaEntities, array("id", "nome", "dataCadastro"=>array("timestamp"), "origemCadastro"=>array("id", "nome", "pessoas"=>array("id","nome","origemCadastro")),
     *               "Enderecos"=>array(
     *                   "pais"=>array(
     *                       "nome"),
     *                   "municipio",
     *                   "bairro"
     *                   )
     *               ));
     * $this->montaObjeto($clientes, array("id", "nome", "dependentes";
     *
     * @param mixed $objetos Um objeto um ou Array de objetos
     * @param array $campos Lista de campos que devem ser montados
     * @param array $config Configurações a serem passadas (Inativo)
     * @param array $mudarNomes Caso queira mudar o nome de algum campo, deve ser passado por exemplo: array("emails"=>"email") o campo emails será rotulado como email
     * @return array Array com um ou mais objetos.
     *
     */
    protected function montaObjeto($objetos, $campos, $config = array(), $mudarNomes = array(), $forceArray = false)
    {
        $arrMount = array();
        if (count($campos) < 1 || $objetos === NULL) {
            //Nenhum campo informado
            return null;
        }
        if (is_object($objetos) || count($objetos) > 0) {
            //Varre um ou mais objetos
            foreach ($objetos as $index => $obj) {
                if (!$obj) {
                    continue;
                }
                foreach ($campos as $key => $campo) {
                    //Verificar subchamadas
                    if (is_array($campo)) {
                        //Relacionamento com getters definidos
                        $classePai = 'get' . ucfirst($key);
                        if (!method_exists($obj, $classePai)) {
                            continue;
                        }
                        $result = $this->varreMetodos($classePai, $obj, $campo);

                        if (isset($result)) {
                            $nameKey = $this->getNameForMontaObjeto($key, $mudarNomes);
                            $arrMount[$index][$nameKey] = $result;
                            unset($result);
                        }
                    } else {

                        //Pode ser um campo ou um relacionamento
                        $classePai = 'get' . ucfirst($campo);
                        if (!method_exists($obj, $classePai)) {
                            continue;
                        }

                        $result = $this->varreMetodos($classePai, $obj);

                        if (isset($result)) {
                            $nameKey = $this->getNameForMontaObjeto($campo, $mudarNomes);
                            $arrMount[$index][$nameKey] = $result;
                            unset($result);
                        }
                    }
                }
            }
        } else {
            //Não tem nada.. implementar depois uma exception
            return null;
        }
        if (!is_array($arrMount) || count($arrMount) < 1) {
            return null;
        }

        if (!$forceArray) {
            return count($arrMount) > 1 ? $arrMount : $arrMount[0];
        } else {
            return $arrMount;
        }
    }


    /**
     * Método para Create/Update/Delete simple Entity
     *
     * Exemplos:
     *
     * Uma simples montagem:
     * return $this->basicNewEditDelete(
     *           $request,
     *           AppConfig::class,
     *           AppConfigType::class,
     *           array("POST","PUT","DELETE"),
     *           array("id", "config", "value", "extra"),
     *           array("extra"=>"extra"),
     *           array(
     *               "pessoa" => array(Pessoa::class, array("setPessoa","addConfig"), "id"),
     *               "pais" => array(Pais::class, array("setPais","addConfig"), "paisid"),
     *               "emails" => array(
     *                   "entity" => ContatoEmail::class,
     *                   array("addEmail","setConfig"),
     *                   "email" => array("id")
     *                   )
     *               )
     *           );
     *
     *
     * @param object $request Uma instância do Symfony\Component\HttpFoundation\Request com os parâmetros dinâmicos via GET
     * @param string $entityName Entidade que deseja executar a ação
     * @param string $formTypeClass Classe FormType da entidade
     * @param array $permissoes Array com os métodos permitidos para esta chamada
     * @param array $retornoObjeto Campos do objeto que deverão serem retornados após o create ou update
     * @param array $extraFields Por padrão a função vincula os dados vindos do request por meio do FormType, informações extras devem ser passadas neste parâmetro
     * @param array $relacionamentos Caso exista algum relacionamento com a entidade pode ser passado para ser relacionado.
     *
     * @return object Retorna uma instância do JsonResponse
     *
     */
    protected function basicNewEditDelete(Request $request, $entityName, FormTypeInterface $formTypeClass, $permissoes = array(), $retornoObjeto = array(), $extraFields = array(), $relacionamentos = array())
    {
        $method = $request->getMethod();
        #$name = explode("\\", $entityName);
        $class = $repository = $entityName;
        #$repository = $name[0] . ":" . $class;
        if (!in_array($method, $permissoes)) {
            $this->throwApiProblemException(self::METODO_NAO_DISPONIVEL, 404);
        }

        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        if (is_array($data)) {
            $data = array_filter($data, function ($value) {
                return $value !== NULL;
            });
        }

        $id = $request->get('id') ? $request->get('id') : intval(@$data['id']);

        if ($id == 0) {
            $id = false;
        }

        if (!class_exists($entityName)) {
            $this->throwApiProblemException("Erro interno no sistema. Classe '$class' não encontrada", 404);
        }
        $entity = new $entityName();

        if ($method == "PUT" || $method == "PATH" || $method == "DELETE") {
            if ($id) {
                $entity = $em->getRepository($repository)->find($id);
                if ($entity) {
                    //se existe a entidade vamos tratar o que fazer
                    if ($method == "DELETE") {
                        //Regras específicas para deletar a entidade e não perder dados importantes...
                        $em->remove($entity);
                        $em->flush();
                        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
                    }
                } else {
                    $this->throwApiProblemException("Objeto não encontrado", 404);
                }
            } else {
                $this->throwApiProblemException("Parâmetro de identificação do objeto é necessário.", 404);
            }
        }

        $form = $this->createForm($formTypeClass, $entity);
        $form->submit($data);

        if (count($extraFields) > 0) {
            foreach ($extraFields as $field => $value) {
                $setMethod = "set" . ucfirst($field);
                if (method_exists($entity, $setMethod)) {
                    if (isset($data[$value])) {
                        $entity->{$setMethod}($data[$value]);
                    }
                }
            }
        }

        if (count($relacionamentos) > 0) {
            foreach ($relacionamentos as $key => $value) {
                if (!isset($data[$key]) || !is_array($value)) {
                    continue;
                }
                foreach ($value as $skey => $svalue) {
                    if ($skey == 0 || $skey == "entity") {
                        #$subEntityNamespace = explode('\\', $svalue);
                        #$subRepository = $subEntityNamespace[0] . ':' . $subEntityNamespace[2];
                        $subRepository = $em->getRepository($svalue);
                        unset($subEntity);
                        continue;
                    }
                    if ($skey == 1 || $skey == "metodos") {
                        $metodos = $svalue;
                        continue;
                    }

                    if (is_array($svalue)) { //many
                        //Não implementado ainda
                    } else {
                        if (!isset($data[$key][$svalue])) {
                            continue;
                        }
                        $subID = intval($data[$key][$svalue]);
                        if ($subID < 1) {
                            continue;
                        }
                        $subEntity = isset($subEntity) ? $subEntity : $subRepository->find($subID);

                        if (!method_exists($entity, $metodos[0]) || !method_exists($subEntity, $metodos[1])) {
                            continue;
                        }

                        $entity->{$metodos[0]}($subEntity);
                        $subEntity->{$metodos[1]}($entity);
                    }
                }
            }
        }

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        $em->persist($entity);
        $em->flush();

        $agora = new \DateTime('now');
        $resposta = array(
            "status" => ($method == 'POST' ? "Criado " : "Atualizado ") . (new \DateTime('now'))->format('Y-m-d H:i:s'),
            "entity" => $this->montaObjeto(array($entity), $retornoObjeto)
        );
        return $this->createApiResponse($resposta, ($method == 'POST' ? 201 : 200));

    }

    protected function varreMetodos($classePai, $obj, $campos = null)
    {
        $metodoResultArr = $obj->{$classePai}();
        if (count($metodoResultArr) < 2 && (!is_array($metodoResultArr) && !is_object($metodoResultArr))) {
            #$metodoResultArr = array($metodoResultArr);
            return self::transformObjResponse($metodoResultArr, $classePai);
        } else {
            $metodoResultFinal = array();
            if ($campos !== null) {

                $manualResult = $this->varreSubcampos($campos, $metodoResultArr);

                if (count($manualResult) > 0) {
                    if (count($manualResult) < 2) {
                        return $manualResult[$campos[0]];
                    } else {
                        return $manualResult;
                    }
                }
            }
            if (method_exists($metodoResultArr, "_toArray")) {
                return $metodoResultArr->_toArray();
            } elseif (method_exists($metodoResultArr, "getId")) {
                if (method_exists($metodoResultArr, "getNome")) {
                    return $metodoResult = array(
                        "id" => $metodoResultArr->getId(),
                        "nome" => $metodoResultArr->getNome()
                    );
                } else {
                    return $metodoResult = $metodoResultArr->getId();
                }
            } else {
                foreach ($metodoResultArr as $metodoResult) {

                    if ($campos !== null) {

                        $manualResult = $this->varreSubcampos($campos, $metodoResult);

                        if (count($manualResult) > 0) {
                            if (count($manualResult) < 2) {
                                $manualResult = $manualResult[$campos[0]];
                            } else {
                                $manualResult = $manualResult;
                            }
                            array_push($metodoResultFinal, $manualResult);
                            continue;
                        }
                    }

                    if (method_exists($metodoResult, "getId")) {
                        if (method_exists($metodoResult, "_toArray")) {
                            $name = $metodoResult->_toArray();
                            if (count($name) > 1) {
                                $metodoResult = array(
                                    "id" => $metodoResult->getId(),
                                    $name[0] => $name[1]
                                );
                            } else {
                                $metodoResult = $name[0];
                            }
                        } elseif (method_exists($metodoResult, "getNome")) {
                            $metodoResult = array(
                                "id" => $metodoResult->getId(),
                                "nome" => $metodoResult->getNome()
                            );
                        } else {
                            $metodoResult = $metodoResult->getId();
                        }
                    } else {
                        array_push($metodoResultFinal, $metodoResultArr); //Não é um relacionamento
                        break;
                    }
                    array_push($metodoResultFinal, $metodoResult);
                }
            }
            $test = $metodoResultFinal;
            /*if (count($metodoResultFinal) === 1 && is_array($metodoResultFinal)) {
                #$metodoResultFinal = $metodoResultFinal[0]; //bug fix. toMany deve sempre ser um array de registros.
            }*/
            return $metodoResultFinal;
        }
    }


    private function varreSubcampos($campos, $object)
    {
        $manualResult = array();
        foreach ($campos as $k => $v) {

            if (is_string($k)) {
                $classeFilha = 'get' . ucfirst($k);
                if (!method_exists($object, $classeFilha)) {
                    continue;
                }
                $manualResult[$k] = $this->varreMetodos($classeFilha, $object, $v);
            } else {
                $classeFilha = 'get' . ucfirst($v);
                if (!method_exists($object, $classeFilha)) {
                    continue;
                }
                $manualResult[$v] = $this->varreMetodos($classeFilha, $object);
            }
        }
        return $manualResult;
    }

    protected function getNameForMontaObjeto($name, $mudarNomes)
    {
        if (count($mudarNomes) > 0) {
            foreach ($mudarNomes as $k => $v) {
                if ($k === $name) {
                    return $v;
                }
            }
        }
        return $name;
    }

    /**
     * Recebe um array de erros do formulário
     * @param $erros
     * @return array
     */
    protected function getFormErros($erros)
    {
        $formErros = $erros;
        $erros = '';
        foreach ($formErros as $erro) {
            $erros .= $erro->getMessage() . '. ';
        }

        $response = array(
            "erro" => $erros
        );
        return $response;
    }

    protected function addRelacionamentos($campos, $entityName, $entity, $relEntityName, $relEntity, $form, $validator, $em = null)
    {
        if ($campos) {
            foreach ($campos as $campo => $valor) {
                if ($valor === null) {
                    continue;
                }
                if ($this->metodoExists('set', $campo, $relEntity)) {
                    $relEntity->{'set' . $campo}($valor);
                } else {
                    //Exception
                }
            }

            if ($this->metodoExists('set', $entityName, $relEntity)) {
                $relEntity->{'set' . ucfirst($entityName)}($entity);
            } elseif ($this->metodoExists('add', $entityName, $relEntity)) {
                $relEntity->{'add' . ucfirst($entityName)}($entity);
            } else {
                //Exception
            }

            if ($this->metodoExists('set', $relEntityName, $entity)) {
                $entity->{'set' . ucfirst($relEntityName)}($relEntity);
            } elseif ($this->metodoExists('add', $relEntityName, $entity)) {
                $entity->{'add' . ucfirst($relEntityName)}($relEntity);
            } else {
                //Exception
            }

            /*if ($em) {
                if ($this->metodoExists('get', 'id', $relEntity)) {
                    if ($relEntity->getId() > 0) {
                        //$relEntity = $em->merge($relEntity);
                        $entity = $em->merge($entity);
                    }
                }
            }*/

            $errors = $validator->validate($relEntity);
            if (count($errors) > 0) {
                foreach ($errors as $erro) {
                    $this->addFormError($erro->getMessage(), $form);
                }
            }
        }
    }

    protected function metodoExists($tipo, $metodo, $object)
    {
        $metodo = $tipo . ucfirst($metodo);
        if (method_exists($object, $metodo)) {
            return true;
        }
        return false;
    }

    protected function addFormError($message = 'Erro inesperado no sistema, consulte o administrador', $form)
    {
        $form->addError(new FormError($message));
    }

    protected function checkIndex($field, $index, $return = null)
    {
        return isset($field[$index]) ? $field[$index] : $return;
    }

    /**
     * Método para Manter valores originais em um objeto
     *
     * Exemplos:
     *
     *
     * $this->reattach($entity, $clone, array("id", "tipo", "dataCadastro")
     *
     *
     * @author Tiago Felipe <tiago@tiagofelipe.com>
     *
     * @param object $entity Objeto original onde o formbuilder mesclou os dados vindo do request
     * @param object $clone Clone do objeto original antes de ser mesclado pelo formbuilder
     * @param array $campos Array com os campos que deseja manter originais
     *
     * @return boolean Retorna true se feito com sucesso e false se ocorreu algum erro
     *
     */
    protected function reattach($entity, $clone, $campos)
    {
        if (count($campos) < 1 || !is_array($campos)) {
            return false;
        }
        foreach ($campos as $k => $campo) {
            if ($this->metodoExists('set', $campo, $entity) && $this->metodoExists('get', $campo, $clone)) {
                $originalContent = $clone->{'get' . ucfirst($campo)}();
                $entity->{'set' . ucfirst($campo)}($originalContent);
            } else {
                //die("Falha grave, reattach não foi possível. AppController (reattach)");
                return false;
            }
        }
        return true;
    }

    /**
     * Get a users first name from the full name
     * or return the full name if first name cannot be found
     * e.g.
     * James Smith        -> James
     * James C. Smith   -> James
     * Mr James Smith   -> James
     * Mr Smith        -> Mr Smith
     * Mr J Smith        -> Mr J Smith
     * Mr J. Smith        -> Mr J. Smith
     *
     * @param string $fullName
     * @param bool $checkFirstNameLength Should we make sure it doesn't just return "J" as a name? Defaults to TRUE.
     *
     * @return string
     */
    public static function fullNameToFirstName($fullName, $checkFirstNameLength = true)
    {
        // Split out name so we can quickly grab the first name part
        $nameParts = explode(' ', $fullName);
        $firstName = str_replace('.', '', $nameParts[0]);
        // If the first part of the name is a prefix, then find the name differently
        if (in_array(strtolower($firstName), array('mr', 'ms', 'mrs', 'miss', 'dr', 'sr', 'sra'))) {
            if ($nameParts[2] != '') {
                // E.g. Mr James Smith -> James
                $firstName = $nameParts[1];
            } else {
                // e.g. Mr Smith (no first name given)
                $firstName = $fullName;
            }
        }
        // make sure the first name is not just "J", e.g. "J Smith" or "Mr J Smith" or even "Mr J. Smith"
        if ($checkFirstNameLength && strlen($firstName) < 3) {
            $firstName = $fullName;
        }
        return $firstName;
    }

    // Function to get the client ip address
    public static function get_client_ip_env()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    // Function to detect mobile
    public static function detectPlatform()
    {

        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower(@$_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower(@$_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower(@$_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr(@$_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'tablet';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'mobile';
        } else {
            // do something for everything else
            return 'desktop';
        }

    }

    public static function getBrowser()
    {
        $u_agent = @$_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } else{
            $ub = 'N/d';
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public static function camelCase($string){

    }

    public static function hideCenterContentTest($string){
        return preg_replace("/(?!^).(?!$)/", "*", $string);
    }
}