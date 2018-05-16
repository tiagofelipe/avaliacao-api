<?php
/**
 * Created by PhpStorm.
 * User: casa
 * Date: 05/03/2018
 * Time: 16:46
 */
namespace Uloc\Bundle\AppBundle\Pagination;
class PaginatedCollection
{
    private $_links = array();

    private $items;
    private $total;
    private $count;

    public function __construct(array $items, $totalItems)
    {
        $this->items = $items;
        $this->total = $totalItems;
        $this->count = count($items);}

    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }


}